<?php

namespace Tuan\Fixably\Controller;

class BaseController
{
    protected function buildFormData($data): array
    {
        $formData = [];
        foreach ($data as $key => $value) {
            $formData[] = [
                'name' => $key,
                'contents' => $value
            ];
        }

        return $formData;
    }
}