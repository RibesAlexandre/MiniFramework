<?php
namespace Core\Html;

/**
 * Class Form
 *
 * @package Core\Html
 */
class Form
{
	private $data = [];

	public function __construct($data = [])
	{
		$this->data = $data;
	}

	/**
	 * Retourne un champ de formulaire de type input
	 *
	 * @param string $name
	 * @param string $label
	 * @param array  $options
	 * @param string $type
	 * @return string
	 */
	public function input($name = '', $label = '', $options = [], $type = 'text')
	{
		$label = empty($label) ? ucfirst($name) : $label;
		$label = '<label>' . $label . '</label>';
		if( $type === 'textarea' )
		{
			$input = '<textarea name="' . $name . '" class="form-control">' . $this->getValue($name) . '<textarea>';
		}
		else
		{
			$input = '<input type="' . $type .'" name="' . $name . '" value="' . $this->getValue($name) .'" class="form-control">';
		}
		
		return $this->formGroup($label . $input);
	}
	
	/**
	 * Place le code dans un form-group
	 * 
	 * @param $html
	 * @return string
	 */
	public function formGroup($html)
	{
		return "<div class=\"form-group\">{$html}</div>";
	}

	/**
	 * Retourne un input de type text
	 *
	 * @param string $name
	 * @param string $label
	 * @param array  $options
	 * @return string
	 */
	public function text($name = '', $label = '', $options = [])
	{
		return $this->input($name, $label, $options, 'text');
	}

	/**
	 * Retourne un input de type password
	 *
	 * @param string $name
	 * @param string $label
	 * @param array  $options
	 * @return string
	 */
	public function password($name = '', $label = '', $options = [])
	{
		return $this->input($name, $label, $options, 'password');
	}

	/**
	 * Retourne un input de type email
	 *
	 * @param string $name
	 * @param string $label
	 * @param array  $options
	 * @return string
	 */
	public function email($name = '', $label = '', $options = [])
	{
		return $this->input($name, $label, $options, 'email');
	}

	/**
	 * Retourne un textarea
	 *
	 * @param string $name
	 * @param string $label
	 * @param array  $options
	 * @return string
	 */
	public function textarea($name = '', $label = '', $options = [])
	{
		return $this->input($name, $label, $options, 'email');
	}

	/**
	 * Retourne un select formaté
	 *
	 * @param $name
	 * @param $label
	 * @param $options
	 * @return string
	 */
	public function select($name, $label, $options)
	{
		$label = '<label>' . $label . '</label>';
		$input = '<select name="' . $name . '" class="form-control">';
		$attributes = '';

		foreach( $options as $key => $value )
		{
			if( $key === $this->getValue($name) )
			{
				$attributes = ' selected';
			}
			$input .= '<option value="' . $key . '"' . $attributes . '>' . $value . '</option>';
		}

		$input .= '</select>';
		return $this->formGroup($label . $input);
	}

	/**
	 * Si le formulaire a été saisi, on retourne la valeur du champ
	 *
	 * @param $name
	 * @return null|string
	 */
	public function getValue($name)
	{
		if( isset($_POST[$name]) )
		{
			return htmlspecialchars($_POST[$name]);
		}
		else
		{
			if( is_object($this->data) )
			{
				return $this->data->$name;
			}
			else
			{
				if( isset($this->data[$name]) )
				{
					return $this->data[$name];
				}
				return null;
			}
		}
	}
}