<?php

namespace App\Http\Requests\Monitor;

use App\Jobs\Monitor\MonitorsCheckRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read bool|null $check_uptime
 * @property-read bool|null $check_certificates
 */
class MonitorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'check_uptime' => 'required_without:check_certificates|boolean',
            'check_certificates' => 'required_without:check_uptime|boolean',
        ];
    }

    public function getDTO(): MonitorsCheckRequestDTO
    {
        return new MonitorsCheckRequestDTO((bool)$this->check_uptime, (bool)$this->check_certificates);
    }
}
