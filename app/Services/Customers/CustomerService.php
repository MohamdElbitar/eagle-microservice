<?php

namespace App\Services\Customers;

use Illuminate\Support\Facades\Http;
use App\Interfaces\Admin\AirportRepositoryInterface;
use App\Interfaces\Customers\ContractRepositoryInterface;
use App\Interfaces\Customers\CustomerRepositoryInterface;
use App\Interfaces\Customers\ItemRepositoryInterface;
use App\Repositories\Admin\AirportRepository;
use App\Repositories\Customers\CustomerRepository;
use App\Services\Admin\UserService;
use App\Models\Customer;
use App\Interfaces\AttributesRepositoryInterface;
use App\Repositories\AttributesRepository;



class CustomerService
{
    protected AirportRepository $airportRepository;
    protected CustomerRepository $customerRepository;
    protected AttributesRepository $attributesRepository;
    protected UserService $userService;
    protected  $contractRepository;
    protected  $itemRepository;
    protected  $contractService;


    public function __construct(
        AirportRepositoryInterface      $airportRepository,
        CustomerRepositoryInterface     $customerRepository,
        AttributesRepositoryInterface   $attributesRepository,
        UserService                     $userService,
        ContractRepositoryInterface     $contractRepository,
        ContractService                 $contractService,
        ItemRepositoryInterface         $itemRepository
    ) {
        $this->airportRepository        = $airportRepository;
        $this->customerRepository       = $customerRepository;
        $this->attributesRepository     = $attributesRepository;
        $this->userService              = $userService;
        $this->contractRepository       = $contractRepository;
        $this->itemRepository           = $itemRepository;
        $this->contractService          = $contractService;
    }

    public function mergeItemPivots(Customer $customer)
    {
        $customer->itemMarkups->transform(function ($item) {
            $merged = array_merge($item->toArray(), $item->pivot->toArray());
            unset($merged['pivot']);
            return $merged;
        });

        $customer->contracts->transform(function ($contract) {
            $contract->itemFees->transform(function ($item) {
                $merged = array_merge($item->toArray(), $item->pivot->toArray());
                unset($merged['pivot']);
                return $merged;
            });

            return $contract;
        });
    }

    public function getAllCustomers()
    {

        ($customers = $this->customerRepository->getAll())
            ->map(function ($customer) {
                $this->mergeItemPivots($customer);
            });

        return $customers;
    }


    public function getCustomerById(int $id)
    {
        $this->mergeItemPivots(
            $customer = $this->customerRepository->findById($id)
        );

        return $customer;
    }

    public function createCustomer(array $data)
    {
        $created_by = auth()->user()->id;

        $data['created_by'] = $created_by;
        $createAccount = $data['create_account'] ?? false;
        unset($data['create_account']);

        $password = $data['password'] ?? null;
        unset($data['password']);

        $newAttributes = $data['new_attributes'] ?? [];
        unset($data['new_attributes']);

        $customerType = $data['type'] ?? null;
        if (!in_array($customerType, ['b2b', 'corporate', 'individual'])) {
            throw new \Exception("Invalid customer type.");
        }

        $customer = $this->customerRepository->create($data);
        $this->attributesRepository->storeAttributes($customer->id, 'customer', $newAttributes);

        $items = $this->itemRepository->getAll();
        $customerMarkups = [];

        if ($customerType === 'individual') {
            foreach ($items as $item) {
                foreach ($item->types as $type) {
                    $customerMarkups[] = [
                        'customer_id' => $customer->id,
                        'item_type_id' => $type->id,
                        'markup' => 50,
                        'value_type' => 'amount',
                        'currency' => $data['currency'] ?? 'EGP',
                    ];
                }
            }
            $this->customerRepository->syncMarkups($customer->id, $customerMarkups);
        } elseif (in_array($customerType, ['b2b', 'corporate'])) {
            if (empty($data['markups'])) {
                throw new \Exception("Markups are required for B2B and Corporate customers.");
            }
            $this->customerRepository->syncMarkups($customer->id, $data['markups']);
        }
        if ($customerType === 'individual') {
            $contract = $this->contractRepository->create([
                'customer_id' => $customer->id,
                'contract_number' => 'CN-' . now()->format('YmdHis') . '-' . rand(1000, 9999),
                'subject' => "Default Contract for " . $customer->name,
                'description' => "Auto-generated contract for individual customers.",
                'from_date' => now(),
                'to_date' => now()->addYear(),
            ]);

            $contractFees = [];
            foreach ($items as $item) {
                foreach ($item->types as $type) {
                    $contractFees[] = [
                        'contract_id' => $contract->id,
                        'item_type_id' => $type->id,
                        'fees' => 50,
                        'value_type' => 'amount',
                        'currency' => $data['currency'] ?? 'EGP',
                    ];
                }
            }
            $this->contractRepository->syncFees($contract->id, $contractFees);
        }

        if ($createAccount) {
            if (empty($data['email']) || empty($password)) {
                throw new \Exception("Email and Password are required to create an account.");
            }

            $userData = $data;
            $userData['password'] = bcrypt($password);

            $user = $this->userService->createUserWithRole($userData, 'customer_admin');
            $this->customerRepository->update($customer->id, ['user_id' => $user->id]);

            return [
                'message'       => "Customer and user account created successfully.",
                'customer'      => $customer,
                'contract'      => $contract ?? null,
                'markups'       => $customer->itemMarkups ?? [],
                'fees'          => $contract->itemFees ?? [],
                'user'          => $user,
                'attributes'    => $newAttributes,
            ];
        }

        return [
            'customer'  => $customer->load('user'),
            'contract'  => $contract ?? null,
            'markups'   => $customer->itemMarkups ?? [],
            'fees'      => $contract->itemFees ?? [],
        ];
    }

    public function updateCustomer($id, array $data)
    {
        $newAttributes = $data['new_attributes'] ?? [];
        unset($data['new_attributes']);

        $customer = $this->customerRepository->update($id, $data);

        $this->attributesRepository->storeAttributes($customer->id, 'customer', $newAttributes);

        return $customer->load(['user', 'attributes']);
    }

    public function deleteCustomer(int $id)
    {
        return $this->customerRepository->delete($id);
    }

    public function forceDelete(int $id)
    {
        return $this->customerRepository->forceDelete($id);
    }

    public function restore(int $id)
    {
        return $this->customerRepository->restore($id);
    }

    public function addMarkups(int $id, $types)
    {
        return $this->customerRepository
            ->findById($id)
            ->itemMarkups()
            ->sync($types);
    }

    public function storeGroup(array $data)
    {
        return $this->customerRepository->createGroup($data);
    }




    //old data ERB code

    public function getAirportType($iataCode)
    {
        $airport = $this->airportRepository->findByIataCode(iataCode: $iataCode);

        if (!$airport) {
            return null;
        }

        return ($airport->country === 'Egypt') ? 'Domestic' : 'International';
    }



    public function getCustomersData()
    {
        return $this->customerRepository->getAll();
        // $response = Http::get('http://ec2-13-60-191-186.eu-north-1.compute.amazonaws.com/api/customers');

        // if ($response->failed()) {
        //     return null;
        // }

        // return $response->json();
    }
    public function getCustomerFees($customerId, $itemId, $destinationIata)
    {
        $type = $this->getAirportType($destinationIata);
// dd($type);
        if (!$type) {
            return ['error' => 'Invalid destination'];
        }

        $customersData = $this->getCustomersData()->toArray();

        if (!$customersData) {
            return ['error' => 'Failed to fetch customer data'];
        }

        $customer = collect($customersData)->firstWhere('id', (int) $customerId);
        // dd($customer);

        if (!$customer) {
            return ['error' => 'Customer not found'];
        }

        $feesData = collect($customer['contracts'])
            ->flatMap(fn($contract) => $contract['item_fees'])->toArray();
            // ->firstWhere('id', $itemId);
// dd($feesData);
        if (!$feesData) {
            return ['error' => 'Item not found in contracts'];
        }

        $itemType = collect($feesData)->firstWhere('name', $type)['pivot'] ?? null;

        if (!$itemType) {
            return ['error' => 'Fees not found for this item type'];
        }

        $feesType = $itemType['value_type'] ?? 'amount';
        $fees = [
            'value' => $itemType['fees'],
            'type' => $feesType,
            'currency' => $itemType['currency'] ?? null
        ];

        $markupData = collect($customer['item_markups'])->toArray();
            // ->firstWhere('id', $itemId);

        if (!$markupData) {
            return ['error' => 'Markup not found'];
        }
        // dd($markupData);

        // $markupTypeData = collect($markupData['types'])->firstWhere('name', $type);
        $markupTypeData = collect($markupData)->firstWhere('name', $type)['pivot'] ?? null;
        // dd($markupTypeData);

        if (!$markupTypeData) {
            return ['error' => 'Markup type not found'];
        }

        $markupType = $markupTypeData['value_type'] ?? 'amount';
        $markup = [
            'value' => $markupTypeData['markup'],
            'type' => $markupType,
            'currency' => $markupTypeData['currency'] ?? null
        ];

        return [
            'fees' => $fees,
            'markup' => $markup,
            'item_type' => $type
        ];
    }
}



   // public function getAirportType($iataCode)
    // {
    // $response = Http::get("https://api.aviationstack.com/v1/airports", [
    //     'access_key' => "834a7e8153bed5d7cf05443d8a1be59d"
    // ]);

    // if (!$response->successful()) {
    //     return null;
    // }

    // $airports = $response->json()['data'] ?? [];

    // $airport = collect($airports)->firstWhere('iata_code', $iataCode);

    // if (!$airport) {
    //     return null;
    // }
