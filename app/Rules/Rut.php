<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Rut implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = strval($value); // Convertir $value a un string
        $value = strtoupper(preg_replace('/\.|,|-/', '', $value));
        $value = str_replace(' ', '', $value);

        // Validar que el RUT solo contenga números y un dígito verificador
        if (!preg_match('/^[0-9]+[0-9K]$/', $value)) {
            $fail("El :attribute no es un RUT válido.");
            return;
        }

        $rut = substr($value, 0, -1);
        $dv = substr($value, -1);
        $factor = 2;
        $suma = 0;
        for ($i = strlen($rut) - 1; $i >= 0; $i--) {
            $factor = $factor > 7 ? 2 : $factor;
            if (is_numeric($rut[$i])) {
                $suma += $rut[$i] * $factor++;
            }
        }
        $mod = $suma % 11;
        $dvCalc = $mod == 1 ? 'K' : ($mod == 0 ? 0 : 11 - $mod);
        if($dv != $dvCalc) {
            $fail("El :attribute no es un RUT válido.");
        }
    }
}
