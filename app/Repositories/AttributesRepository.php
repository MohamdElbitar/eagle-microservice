<?php

namespace App\Repositories;


use App\Models\Attributes\Employee\EmployeeAttribute;
use App\Models\Attributes\Employee\EmployeeAttributeValue;
use App\Models\Attributes\Employee\Contracts\EmployeeContractAttribute;

use App\Models\Attributes\Customer\CustomerAttribute;
use App\Models\Attributes\Customer\CustomerAttributeValue;

use Illuminate\Support\Collection;
use Illuminate\Database\QueryException;

use App\Interfaces\AttributesRepositoryInterface;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Symfony\Component\HttpFoundation\JsonResponse;

class AttributesRepository implements AttributesRepositoryInterface
{
    public function getAll()
    {
        return Attribute::all();
    }

    public function findById(int $id)
    {
        return Attribute::findOrFail($id);
    }

    public function create(array $data)
    {
        return Attribute::create($data);
    }

    public function update(int $id, array $data)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->update($data);
        return $attribute;
    }
    public function delete(int $id): JsonResponse
    {
        try
        {
            if ($result = Attribute::destroy($id)) {
                return response()
                        ->json(['message' => 'Attribute deleted'], 200);
            }

            return response()
                    ->json(['message' => 'Attribute not found'], 404);
        }

        catch(QueryException $e) {
            return response()->json(['message' => 'Cannot delete attribute'], 500);
        }
    }

      //employee attributes
      public function storeAttributes(int $entityId, string $category, array $attributes)
      {
          foreach ($attributes as $attribute) {
              if (isset($attribute['attribute_id'])) {
                  // Use existing attribute
                  $attributeId = $attribute['attribute_id'];
              } else {
                  // Create a new attribute if not exists
                  $existingAttribute = Attribute::firstOrCreate([
                      'name' => $attribute['name'],
                      'type' => $attribute['type'],
                      'category' => $category,
                  ]);

                  $attributeId = $existingAttribute->id;
              }

              // Store the attribute value for the employee, client, or contract
              AttributeValue::create([
                  'entity_id' => $entityId,
                  'attribute_id' => $attributeId,
                  'value' => $attribute['value'],
              ]);
          }
      }

}
