<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * Class AttachSiteRequest
 * @package App\Http\Requests
 *
 * @property int site_id
 * @property bool active
 * @property string external_id
 */
class AttachSiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'site_id' => 'required|exists:sites,id',
            'active' => 'required|boolean',
            'external_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('provider_site', 'external_id')->where(function ($query) {
                    return $query
                        ->where('provider_id', $this->route('provider'))
                        ->where('site_id', $this->input('site_id'));
                }),
            ],
        ];
    }
}
