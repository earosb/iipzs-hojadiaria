<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    /**
     * Redirect back with errors
     * @param $validator
     * @return $this
     */
    protected function redirectBackWithErrors($validator)
    {
        return Redirect::back()->withInput()->withErrors($validator->messages());
    }

}
