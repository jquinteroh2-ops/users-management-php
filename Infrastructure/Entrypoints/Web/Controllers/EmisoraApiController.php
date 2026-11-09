<?php

declare(strict_types=1);

require_once __DIR__ . '/EmisoraController.php';
require_once __DIR__ . '/../../../../Domain/Exceptions/InvalidEmisoraException.php';
require_once __DIR__ . '/../../../../Domain/Exceptions/EmisoraNotFoundException.php';
require_once __DIR__ . '/../../../../Domain/Exceptions/EmisoraAlreadyExistsException.php';

/**
 * Entrypoint REST (JSON) del CRUDL de emisoras. Lo usan Postman y Swagger.
 *
 * Reutiliza EmisoraController y convierte las excepciones del dominio en
 * códigos HTTP (manejador de errores):
 *   InvalidEmisoraException / errores de validación -> 400
 *   EmisoraNotFoundException                       -> 404
 *   EmisoraAlreadyExistsException                  -> 409
 *   cualquier otro error                           -> 500
 */
final class EmisoraApiController
{
    public function __construct(private EmisoraController $controller)
    {
    }

    public function handle(string $action): void
    {
        try {
            switch ($action) {
                case 'api.emisoras.index':
                    $data = array_map(
                        static fn(EmisoraResponse $r): array => $r->toArray(),
                        $this->controller->index()
                    );
                    self::json(200, $data);
                    return;

                case 'api.emisoras.show':
                    self::json(200, $this->controller->show(self::queryId())->toArray());
                    return;

                case 'api.emisoras.store':
                    $body = self::jsonBody();
                    $request = EmisoraWebRequest::fromArray((string) ($body['id'] ?? self::uuid4()), $body);
                    self::ensureValid($request);
                    self::json(201, $this->controller->store($request)->toArray());
                    return;

                case 'api.emisoras.update':
                    $request = EmisoraWebRequest::fromArray(self::queryId(), self::jsonBody());
                    self::ensureValid($request);
                    self::json(200, $this->controller->update($request)->toArray());
                    return;

                case 'api.emisoras.delete':
                    $this->controller->delete(self::queryId());
                    http_response_code(204);
                    return;

                default:
                    self::json(404, array('status' => 404, 'message' => 'Ruta de API no encontrada.'));
            }
        } catch (EmisoraNotFoundException $e) {
            self::json(404, array('status' => 404, 'message' => $e->getMessage()));
        } catch (EmisoraAlreadyExistsException $e) {
            self::json(409, array('status' => 409, 'message' => $e->getMessage()));
        } catch (InvalidEmisoraException | InvalidArgumentException $e) {
            self::json(400, array('status' => 400, 'message' => $e->getMessage()));
        } catch (ApiValidationException $e) {
            self::json(400, array('status' => 400, 'message' => $e->getMessage(), 'errors' => $e->errors));
        } catch (Throwable $e) {
            error_log('[EmisoraApi] ' . $e->getMessage());
            self::json(500, array('status' => 500, 'message' => 'Error interno del servidor.'));
        }
    }

    private static function ensureValid(EmisoraWebRequest $request): void
    {
        $errors = $request->validate();

        if (!empty($errors)) {
            throw new ApiValidationException($errors);
        }
    }

    private static function queryId(): string
    {
        $id = trim((string) ($_GET['id'] ?? ''));

        if ($id === '') {
            throw new InvalidArgumentException('El parámetro id es obligatorio.');
        }

        return $id;
    }

    /**
     * @return array<string, mixed>
     */
    private static function jsonBody(): array
    {
        $decoded = json_decode((string) file_get_contents('php://input'), true);

        if (!is_array($decoded)) {
            throw new InvalidArgumentException('El cuerpo de la petición debe ser un JSON válido.');
        }

        return $decoded;
    }

    private static function uuid4(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * @param array<mixed> $payload
     */
    public static function json(int $status, array $payload): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);
    }
}

/**
 * Errores de validación del cuerpo JSON (campo => mensaje).
 */
final class ApiValidationException extends RuntimeException
{
    /**
     * @param array<string, string> $errors
     */
    public function __construct(public readonly array $errors)
    {
        parent::__construct('Datos inválidos.');
    }
}
