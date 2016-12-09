<?php

namespace CopyaPost\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO::enhance security feature
        // check if gate would be applicable here
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(!$this->has('action')){
            return [
                'title' => 'required',
                'content' => 'required',
                'status' => 'required'
            ];
        } else {
            return [];
        }
    }
}
