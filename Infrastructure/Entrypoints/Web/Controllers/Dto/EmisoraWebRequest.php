<?php

declare(strict_types=1);

/**
 * Datos de una emisora recibidos desde el formulario web o desde la API JSON.
 *
 * Se encarga de convertir los textos recibidos (todo llega como string) a los
 * tipos correctos y de la validación de formulario (campos vacíos, números).
 * Las reglas de negocio (rangos de frecuencia, unicidad...) las valida el dominio.
 */
final class EmisoraWebRequest
{
    public const FIELDS = array(
        'nombre', 'canal', 'bandaFm', 'bandaAm', 'numLocutores', 'genero', 'horario',
        'patrocinador', 'pais', 'descripcion', 'numProgramas', 'numCiudades',
    );

    /** @var array<string, string> */
    private array $raw;

    /**
     * @param array<string, string> $raw
     */
    private function __construct(private string $id, array $raw)
    {
        $this->raw = $raw;
    }

    /**
     * @param array<string, mixed> $input
     */
    public static function fromArray(string $id, array $input): self
    {
        $raw = array();

        foreach (self::FIELDS as $field) {
            $value = $input[$field] ?? '';
            $raw[$field] = is_scalar($value) ? trim((string) $value) : '';
        }

        return new self(trim($id), $raw);
    }

    /**
     * Valores tal como llegaron, para volver a llenar el formulario si hay errores.
     *
     * @return array<string, string>
     */
    public function old(): array
    {
        return array('id' => $this->id) + $this->raw;
    }

    /**
     * @return array<string, string> campo => mensaje
     */
    public function validate(): array
    {
        $errors = array();

        foreach (array('nombre', 'canal', 'genero', 'horario', 'pais') as $required) {
            if ($this->raw[$required] === '') {
                $errors[$required] = 'Este campo es obligatorio.';
            }
        }

        if ($this->raw['bandaFm'] === '' && $this->raw['bandaAm'] === '') {
            $errors['bandaFm'] = 'Indique la frecuencia FM, la AM o ambas.';
        }

        if ($this->raw['bandaFm'] !== '' && !is_numeric(str_replace(',', '.', $this->raw['bandaFm']))) {
            $errors['bandaFm'] = 'La frecuencia FM debe ser un número (por ejemplo 95.5).';
        }

        if ($this->raw['bandaAm'] !== '' && !ctype_digit($this->raw['bandaAm'])) {
            $errors['bandaAm'] = 'La frecuencia AM debe ser un número entero (por ejemplo 1170).';
        }

        foreach (array('numLocutores', 'numProgramas', 'numCiudades') as $integer) {
            if ($this->raw[$integer] === '' || !ctype_digit($this->raw[$integer])) {
                $errors[$integer] = 'Debe ser un número entero mayor o igual a cero.';
            }
        }

        return $errors;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->raw['nombre'];
    }

    public function getCanal(): string
    {
        return $this->raw['canal'];
    }

    public function getBandaFm(): ?float
    {
        return $this->raw['bandaFm'] === '' ? null : (float) str_replace(',', '.', $this->raw['bandaFm']);
    }

    public function getBandaAm(): ?int
    {
        return $this->raw['bandaAm'] === '' ? null : (int) $this->raw['bandaAm'];
    }

    public function getNumLocutores(): int
    {
        return (int) $this->raw['numLocutores'];
    }

    public function getGenero(): string
    {
        return strtoupper($this->raw['genero']);
    }

    public function getHorario(): string
    {
        return $this->raw['horario'];
    }

    public function getPatrocinador(): string
    {
        return $this->raw['patrocinador'];
    }

    public function getPais(): string
    {
        return $this->raw['pais'];
    }

    public function getDescripcion(): string
    {
        return $this->raw['descripcion'];
    }

    public function getNumProgramas(): int
    {
        return (int) $this->raw['numProgramas'];
    }

    public function getNumCiudades(): int
    {
        return (int) $this->raw['numCiudades'];
    }
}
