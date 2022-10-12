<?php
namespace App\Services;

use App\Enum\HttpResponses;
use App\Services\Contract\IValidationRequest;
use App\Validation\Contracts\AbstractValidation;
use Illuminate\Http\Request;
use Mockery\Exception;

class ValidationRequest implements  IValidationRequest
{
        public function __construct(
            private AbstractValidation $abstractValidation,
            private Request $request
        )
        {
        }

        public function validate() : void
        {
           $validator = $this->abstractValidation->make($this->request->all());

           if($validator->fails()){
               throw new Exception($validator->errors(), HttpResponses::UNPROCESSABLE_ENTITY->value);
           }
        }
}
