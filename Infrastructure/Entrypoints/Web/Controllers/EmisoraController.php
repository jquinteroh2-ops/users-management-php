<?php

declare(strict_types=1);

require_once __DIR__ . '/Mapper/EmisoraWebMapper.php';
require_once __DIR__ . '/../../../../Application/Ports/In/CreateEmisoraUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/UpdateEmisoraUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetEmisoraByIdUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetAllEmisorasUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/DeleteEmisoraUseCase.php';
require_once __DIR__ . '/../../../../Application/Services/Dto/Queries/GetAllEmisorasQuery.php';

/**
 * Controlador del CRUDL de emisoras. Solo traduce peticiones y delega en los casos de uso.
 */
final class EmisoraController
{
    public function __construct(
        private CreateEmisoraUseCase $createEmisoraUseCase,
        private UpdateEmisoraUseCase $updateEmisoraUseCase,
        private GetEmisoraByIdUseCase $getEmisoraByIdUseCase,
        private GetAllEmisorasUseCase $getAllEmisorasUseCase,
        private DeleteEmisoraUseCase $deleteEmisoraUseCase,
        private EmisoraWebMapper $mapper
    ) {
    }

    /**
     * @return EmisoraResponse[]
     */
    public function index(): array
    {
        $emisoras = $this->getAllEmisorasUseCase->execute(new GetAllEmisorasQuery());

        return $this->mapper->fromModelsToResponses($emisoras);
    }

    public function show(string $id): EmisoraResponse
    {
        $emisora = $this->getEmisoraByIdUseCase->execute($this->mapper->fromIdToGetByIdQuery($id));

        return $this->mapper->fromModelToResponse($emisora);
    }

    public function store(EmisoraWebRequest $request): EmisoraResponse
    {
        $emisora = $this->createEmisoraUseCase->execute($this->mapper->fromRequestToCreateCommand($request));

        return $this->mapper->fromModelToResponse($emisora);
    }

    public function update(EmisoraWebRequest $request): EmisoraResponse
    {
        $emisora = $this->updateEmisoraUseCase->execute($this->mapper->fromRequestToUpdateCommand($request));

        return $this->mapper->fromModelToResponse($emisora);
    }

    public function delete(string $id): void
    {
        $this->deleteEmisoraUseCase->execute($this->mapper->fromIdToDeleteCommand($id));
    }
}
