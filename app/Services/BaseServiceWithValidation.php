<?php

namespace App\Services;

use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Validation\ValidationException;

/**
 * Base class for services with validation.
 */
abstract class BaseServiceWithValidation extends BaseService
{
    /**
     * Validation factory.
     *
     * @var ValidationFactory
     */
    protected $validationFactory;
    
    /**
     * BaseServiceWithValidation constructor.
     *
     * @param ValidationFactory $validationFactory Validation factory
     */
    public function __construct(ValidationFactory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }
    
    /**
     * Validate data.
     *
     * @param array $data Data for validation
     * @param array $roles Roles for validation
     *
     * @return void
     *
     * @throws ValidationException
     */
    protected function validate(array $data, array $roles): void
    {
        $validator = $this->validationFactory->make($data, $roles);
        
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
