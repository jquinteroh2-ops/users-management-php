<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/EmisoraWebRequest.php';
require_once __DIR__ . '/../Dto/EmisoraResponse.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/CreateEmisoraCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/UpdateEmisoraCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/DeleteEmisoraCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Queries/GetEmisoraByIdQuery.php';
require_once __DIR__ . '/../../../../../Domain/Models/EmisoraModel.php';

/**
 * Convierte peticiones web en comandos/consultas y modelos en respuestas.
 */
final class EmisoraWebMapper
{
    public function fromRequestToCreateCommand(EmisoraWebRequest $request): CreateEmisoraCommand
    {
        return new CreateEmisoraCommand(
            $request->getId(),
            $request->getNombre(),
            $request->getCanal(),
            $request->getBandaFm(),
            $request->getBandaAm(),
            $request->getNumLocutores(),
            $request->getGenero(),
            $request->getHorario(),
            $request->getPatrocinador(),
            $request->getPais(),
            $request->getDescripcion(),
            $request->getNumProgramas(),
            $request->getNumCiudades()
        );
    }

    public function fromRequestToUpdateCommand(EmisoraWebRequest $request): UpdateEmisoraCommand
    {
        return new UpdateEmisoraCommand(
            $request->getId(),
            $request->getNombre(),
            $request->getCanal(),
            $request->getBandaFm(),
            $request->getBandaAm(),
            $request->getNumLocutores(),
            $request->getGenero(),
            $request->getHorario(),
            $request->getPatrocinador(),
            $request->getPais(),
            $request->getDescripcion(),
            $request->getNumProgramas(),
            $request->getNumCiudades()
        );
    }

    public function fromIdToGetByIdQuery(string $id): GetEmisoraByIdQuery
    {
        return new GetEmisoraByIdQuery($id);
    }

    public function fromIdToDeleteCommand(string $id): DeleteEmisoraCommand
    {
        return new DeleteEmisoraCommand($id);
    }

    public function fromModelToResponse(EmisoraModel $emisora): EmisoraResponse
    {
        return new EmisoraResponse(
            $emisora->id()->value(),
            $emisora->nombre()->value(),
            $emisora->canal(),
            $emisora->bandaFm()?->value(),
            $emisora->bandaAm()?->value(),
            $emisora->numLocutores(),
            $emisora->genero(),
            $emisora->horario(),
            $emisora->patrocinador(),
            $emisora->pais(),
            $emisora->descripcion(),
            $emisora->numProgramas(),
            $emisora->numCiudades()
        );
    }

    /**
     * @param EmisoraModel[] $emisoras
     * @return EmisoraResponse[]
     */
    public function fromModelsToResponses(array $emisoras): array
    {
        $responses = array();

        foreach ($emisoras as $emisora) {
            $responses[] = $this->fromModelToResponse($emisora);
        }

        return $responses;
    }
}
