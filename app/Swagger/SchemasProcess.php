<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Process",
 *     type="object",
 *     title="Process",
 *     description="Modelo de ejemplo",
 *     required={"id", "city", "office_id", "demanding_id", "defendant_id", "attorney_id", "niu", "reference_internal", "reference_external", "facts", "class_procces_id", "action_id", "status_id", "failure_possibility_id", "failure_possibility"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="city", type="string", example="NY"),
 *     @OA\Property(property="office_id", type="integer", example=1),
 *     @OA\Property(property="demanding_id", type="integer", example=2),
 *     @OA\Property(property="defendant_id", type="integer", example=3),
 *     @OA\Property(property="attorney_id", type="integer", example=4),
 *     @OA\Property(property="niu", type="string", example="123456"),
 *     @OA\Property(property="reference_internal", type="string", example="internal_ref"),
 *     @OA\Property(property="reference_external", type="string", example="external_ref"),
 *     @OA\Property(property="facts", type="string", example="Some facts"),
 *     @OA\Property(property="class_procces_id", type="integer", example=5),
 *     @OA\Property(property="action_id", type="integer", example=6),
 *     @OA\Property(property="status_id", type="integer", example=7),
 *     @OA\Property(property="failure_possibility_id", type="integer", example=8),
 *     @OA\Property(property="failure_possibility", type="string", example="High"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
 * )
 */
class SchemasProcess
{
}
