<?php

namespace FreeBlade;

use Exception;

/**
 * Class responsible for rendering template engine views.
 *
 * @author Emmy Gomes <aou-emmy@outlook.com>
 */
class Template
{
	/**
	 * Save the contents of the main view.
	 *
	 * @var String $viewContent
	 */
	protected static $viewContent;

	/**
	 * Save the contents of an extended view.
	 *
	 * @var String $extendedViewContent
	 */
	protected static $extendedViewContent;

	/**
	 * Defines new content for the final view.
	 *
	 * @param String $viewContent
	 * 
	 * @return void
	 */
	protected static function setViewContent($viewContent)
	{
		// Stores the new value
		self::$viewContent = $viewContent;
	}

	/**
	 * [Remover]
	 * Define o conteudo da view extendida para o informado.
	 *
	 * @param String $extendedViewContent
	 * 
	 * @return void
	 */
	protected static function setExtendedViewContent($extendedViewContent)
	{
		// Define o conteudo da view
		self::$extendedViewContent = $extendedViewContent;
	}

	/**
	 * Changes the terms between double brackets ({{}}) to the respective value of their variables.
	 *
	 * @param Array $params
	 *
	 * @return void
	 */
	protected static function setParams($params)
	{
		// Saves the formatted view content
		$newViewContent = self::$viewContent;

		// Loop in $params
		foreach ($params as $key => $value) {
			// Checks whether $value is an array
			if (gettype($value) == "array") {
				// Skip to the next item
				continue;
			}

			// Replace $key with $value
			$newViewContent = str_replace("{{ ".$key." }}", $value, self::$viewContent);
		}

		// Save new view content
		self::setViewContent($newViewContent);
	}

	/**
	 * Exchanges the @if/@elseif/@else/@endif keys for the respective one in php.
	 *
	 * @return void
	 */
	protected static function setConditionalStructures()
	{
		// Saves the formatted view content
		$newViewContent = self::$viewContent;

		// Convert @ keys into php code
		$newViewContent = preg_replace('~@if([^\r\n}]+):~', "<?php if ($1): ?>", $newViewContent);
		$newViewContent = preg_replace('~@elseif([^\r\n}]+):~', "<?php elseif ($1): ?>", $newViewContent);
		$newViewContent = preg_replace('~@else:~', '<?php else: ?>', $newViewContent);
		$newViewContent = preg_replace('~@endif~', '<?php endif; ?>', $newViewContent);

		// Save new view content
		self::setViewContent($newViewContent);
	}

	/**
	 * Exchanges the @foreach/@endforeach keys for the respective one in php.
	 *
	 * @return void
	 */
	protected static function setForeach($params)
	{
		// Saves the formatted view content
		$newViewContent = self::$viewContent;

		// Convert @ keys into php code
		$newViewContent = preg_replace('~@foreach (\w+) as (\w+) => (\w+):~', '<?php foreach ($params["$1"] as \$$2 => \$$3): ?>', $newViewContent);
		$newViewContent = preg_replace('~\{\{ (\w+) \}\}~', "<?php echo \$$1; ?>", $newViewContent);
		$newViewContent = preg_replace('~@endforeach~', '<?php endforeach; ?>', $newViewContent);

		// Save new view content
		self::setViewContent($newViewContent);
	}

	/**
	 * Exchanges the single brackets ({}) for the view functions.
	 *
	 * @return void
	 */
	protected static function setViewFunctions()
	{
		// Saves the formatted view content
		$newViewContent = self::$viewContent;

		// Exchanges square brackets ({}) with php tags
		$newViewContent = preg_replace('~\{ ([^\r\n}]+) \}~', "<?php FreeBlade\Views::$1; ?>", $newViewContent);

		// Save new view content
		self::$viewContent = $newViewContent;
	}

	/**
	 * Extends the contents of a view.
	 *
	 * @return void
	 */
	protected static function extendView()
	{
		// Checks whether @extend exists in the view
		if (strpos(self::$viewContent, "@extends") === false) {
			// Closes the function
			return false;
		}

		// Get the partial name of the view to be extended
		$viewNameStart = substr(self::$viewContent, strpos(self::$viewContent, "@extends('")+10);

		// Stores the name of the view to be extended
		$toExtend = str_replace(substr($viewNameStart, strpos($viewNameStart, "')")), "", $viewNameStart);

		// Saves the formatted view content
		$newViewContent = str_replace("@extends('".$toExtend."')", "", self::$viewContent);

		// Replaces periods (.) With the DIRECTORY_SEPARATOR constant
		$toExtend = str_replace(".", DIRECTORY_SEPARATOR, $toExtend);

		// Checks whether the extended view exists
		if (!file_exists(VIEWS . $toExtend . ".blade.php")) {
			// Return false
			return false;
		}

		// Pega o conteudo da view
		$newExtendedViewContent = file_get_contents(VIEWS . $toExtend . ".blade.php");

		// Save new extended view content
		self::setExtendedViewContent($newExtendedViewContent);
	}

	/**
	 * Joins the extended view (if any) with the requested view.
	 *
	 * @return void
	 */
	protected static function joinViews()
	{
		// Checks if there is a view to be extended
		if (empty(self::$extendedViewContent)) {
			// Return false
			return false;
		}

		// Fetch sessions in the child view
		while (strpos(self::$viewContent, "@section") !== false) {
			// Save extended view content
			$newExtendedViewContent = self::$extendedViewContent;

			// Save view content
			$viewContent = self::$viewContent;

			// Save the beginning of the section
			$sectionStart = strpos($viewContent, "@section('")+10;

			// Save the end of the section
			$sectionEnd = strpos($viewContent, "@endsection");

			// Partial section name
			$partialSectionName = substr($viewContent, $sectionStart);

			// Parent view yield name
			$yieldName = str_replace(substr($partialSectionName, strpos($partialSectionName, "')")), "", $partialSectionName);

			// Partial section content
			$sectionContent = str_replace("{$yieldName}')", "", $partialSectionName);

			// Section content
			$sectionContent = str_replace(substr($sectionContent, strpos($sectionContent, "@endsection")), "", $sectionContent);

			// Replaces @yield in the parent view with the content of @section
			$newExtendedViewContent = str_replace("@yield('".$yieldName."')", $sectionContent, $newExtendedViewContent);

			// Saave new extended view content
			self::$extendedViewContent = $newExtendedViewContent;

			// Delete entire section
			self::$viewContent = str_replace("@section('{$yieldName}')", "", $viewContent);
		}

		// Defines the content of the final view with the content of the two views together
		self::setViewContent(preg_replace('~@yield([^\r\n}]+)~', "", $newExtendedViewContent));
	}

	/**
	 * Performs all necessary methods for rendering the view.
	 * 
	 * @param String $viewContent
	 * @param Array $params
	 *
	 * @return void
	 */
	public static function render($viewContent, $params=[])
	{
		// Checks whether the file exists
		if (!file_exists(VIEWS . $viewContent . ".blade.php")) {
			// Generates an error
			throw new Exception("View {$viewContent} does not exist.");
			
			// Closes the function
			return false;
		}
		else {
			// Get the contents of the view
			$viewContent = file_get_contents(VIEWS . $viewContent . ".blade.php");
		}

		// Defines a view content for access within the class
		self::setViewContent($viewContent);

		// Load an extended view
		self::extendView();

		// Joins views if there are extensions
		self::joinViews();

		// Changes the variables within brackets ({}) to the php equivalent
		self::setParams($params);

		// Change the @if/@elseif/@else fields to the php equivalent
		self::setConditionalStructures();

		// Change the @foreach/@endforeach fields to the php equivalent
		self::setForeach($params);

		// Swap view functions for php tags
		self::setViewFunctions();

		// Renders the view
		eval("?>" . self::$viewContent);
	}
}

?>