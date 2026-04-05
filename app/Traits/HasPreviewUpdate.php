<?php

namespace App\Traits;

trait HasPreviewUpdate
{
    /**
     * Compara los datos actuales del modelo contra los nuevos datos propuestos,
     * devolviendo un array con aquellos campos que sufririan un cambio real.
     *
     * @param array $newData Array asociativo equivalente a un $request->validated()
     * @return array [ 'columna' => ['antes' => 'viejo', 'despues' => 'nuevo'] ]
     */
    public function getPreviewChanges(array $newData): array
    {
        // Clonamos el modelo para no ensuciar la instancia actual usada en la app
        $previewModel = clone $this;
        
        // Rellenamos el modelo para detectar los "dirties"
        $previewModel->fill($newData);
        $changes = $previewModel->getDirty();
        $original = $previewModel->getOriginal();

        $preview = [];

        foreach ($changes as $key => $nuevoValor) {
            $valorAnterior = array_key_exists($key, $original) ? $original[$key] : null;

            // Ignorar casts iguales, por ejemplo decimales equivalentes
            if ((string)$valorAnterior !== (string)$nuevoValor) {
                $preview[$key] = [
                    'antes' => $valorAnterior,
                    'despues' => $nuevoValor
                ];
            }
        }

        return $preview;
    }
}
