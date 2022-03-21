<?php

namespace Deyjandi\VivaWallet\Traits;

trait FiltersUnsetData
{
    public function filterUnsetData(array $data): array
    {
        return array_filter($data, fn (mixed $item) => isset($item));
    }
}
