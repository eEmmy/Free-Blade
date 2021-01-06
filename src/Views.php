<?php

namespace FreeBlade;

use MatthiasMullie\Minify;

/**
 * Functions to be used when editing all views. 
 */
class Views
{
	/**
	 * Displays the conifgured base url concatenated with the past address.
	 *
	 * @param String $page
	 *
	 * @return Bool true
	 */
	public static function url($page)
	{
		// Checks if the url passed was "/"
		if ($page == "/") {
			// Changes to empty so that there are no conflicts with the BASE_URL constant
			$page = "";
		}

		// Displays the string with the full url
		echo BASE_URL . $page;

		// Closes the function
		return true;
	}

	/**
	 * Minify a CSS file.
	 *
	 * @param String $file
	 *
	 * @return String $minifiedCss
	 */
	protected static function minifyCss($file)
	{
		// Instantiate an object Minify
		$minifier = new Minify\CSS($file);

		// Save minified content
		$minifiedCss = $minifier->minify();

		// Returns minified content
		return $minifiedCss;
	}

	/**
	 * Minify a js file.
	 *
	 * @param String $file
	 *
	 * @return String $minifiedJs
	 */
	protected static function minifyJs($file)
	{
		// Instantiate an object Minify
		$minifier = new Minify\JS($file);

		// Save minified content
		$minifiedJs = $minifier->minify();

		// Returns minified content
		return $minifiedJs;
	}

	/**
 	* Loads a CSS file.
 	*
 	* @param String $file
 	*
 	* @return Bool
 	*/
	public static function css($file) 
	{
		// Replaces periods (.) With the DIRECTORY_SEPARATOR constant
		$file = str_replace(".", DIRECTORY_SEPARATOR, $file);

		// Save only the file name
		$fileName = $file . ".css";

		// Mount the file path
		$file = CSS_DIR . $file . ".css";

		// Checks whether the file exists
		if (!file_exists($file)) {
			// Return false
			return false;
		}

		// Minify file contents
		$file = self::minifyCss($file);

		// Displays the link tag
		echo "<!-- {$fileName} -->\n<style type=\"text/css\">" . $file . "</style>";

		// Closes the function
		return true;
	}

	/**
 	* Carrega um arquivo css em public/js
 	*
 	* @param String $file
 	*
 	* @return Bool
 	*/
	public static function js($file) 
	{
		// Replaces periods (.) With the DIRECTORY_SEPARATOR constant
		$file = str_replace(".", DIRECTORY_SEPARATOR, $file);

		// Save only the file name
		$fileName = $file . ".js";

		// Mount the file path
		$file = JS_DIR . $file . ".js";

		// Checks whether the file exists
		if (!file_exists($file)) {
			// Return false
			return false;
		}

		// Minify file contents
		$file = self::minifyJs($file);

		// Displays the script tag
		echo "<!-- {$fileName} -->\n<script type=\"text/javascript\">" . $file . "</script>";

		// Closes the function
		return true;
	}

	/**
	 * Convert an image to base64 and show the string.
	 *
	 * @param String $imageName
	 * @param String $imageType
	 *
	 * @return void
	 */
	public static function image($imageName, $imageType)
	{
		// Checks whether the type of image passed is valid
		if (empty($imageType) || !in_array($imageType, ["png", "jpg", "jpeg", "gif", "bmp", "svg"])) {
			// Returns the error warning
			echo "{$imageType} is an unknown image type.";
			
			// Return false
			return false;
		}

		// Replaces periods (.) With the DIRECTORY_SEPARATOR constant
		$imageName = str_replace(".", DIRECTORY_SEPARATOR, $imageName) . ".{$imageType}";

		// Saves the complete image path
		$imagePath = IMAGE_DIR . $imageName;

		// Checks whether the image exists
		if (!file_exists($imagePath)) {
			// Returns the error warning
			echo "The {$imageName} file does not exist";
			
			// Return false
			return false;
		}

		// Take the content of $imagePath
		$image = file_get_contents($imagePath);

		// Save the final code of the image
		$imageSrc = "";

		// Checks the type of image
		switch ($imageType) {
			case "png":
				$imageSrc = "data:image/png;base64,";
				break;
			
			case "jpg":
				$imageSrc = "data:image/jpeg;base64,";
				break;

			case "jpeg":
				$imageSrc = "data:image/jpeg;base64,";
				break;

			case "gif":
				$imageSrc = "data:image/gif;base64,";
				break;

			case "bmp":
				$imageSrc = "data:image/bmp;base64";

			case "svg":
				$imageSrc = "data:image/svg+xml;base64,";
				break;
			
			default:
				break;
		}

		// Add the base64 string to the image code
		$imageSrc .= base64_encode($image);

		// Displays the image code
		echo $imageSrc;

		// Closes the function
		return true;
	}

	/**
	 * Convert an audio file to base64 and show the string.
	 *
	 * @param String $audioName
	 * @param String $audioType
	 *
	 * @return Bool
	 */
	public static function audio($audioName, $audioType="")
	{
		// Checks whether the type of audio passed is valid
		if (empty($audioType) || !in_array($audioType, ["mp3", "ogg", "wav"])) {
			// Checks the type of audio
			switch ($audioName) {
				case "mp3":
					// Displays the MIME type of the video
					echo "audio/mpeg;";
					break;
			
				case "ogg":
					// Displays the MIME type of the video
					echo "audio/ogg";
					break;

				case "wav":
					// Displays the MIME type of the video
					echo "audio/x-wav";
					break;
			
				default:
					break;
			}
			
			// Closes the function
			return true;
		}

		// Replaces periods (.) With the DIRECTORY_SEPARATOR constant
		$audioName = str_replace(".", DIRECTORY_SEPARATOR, $audioName) . ".{$audioType}";

		// Saves the complete audio path
		$audioPath = AUDIO_DIR . $audioName;

		// Checks whether audio exists
		if (!file_exists($audioPath)) {
			// Returns the error warning
			echo "The {$audioName} file does not exist";
			
			// Return false
			return false;
		}

		// Take the content of $audioPath
		$audio = file_get_contents($audioPath);

		// Save the final code of the audio
		$audioSrc = "";

		// Checks the type of audio
		switch ($audioType) {
			case "mp3":
				$audioSrc = "data:audio/mpeg;base64,";
				break;
			
			case "ogg":
				$audioSrc = "data:audio/ogg;base64,";
				break;

			case "wav":
				$audioSrc = "data:audio/x-wav;base64,";
				break;
			
			default:
				break;
		}

		// Add the base64 string to the audio code
		$audioSrc .= base64_encode($audio);

		// Displays the audio code
		echo $audioSrc;

		// Closes the function
		return true;
	}

	/**
	 * Convert a video file to base64 and show the string.
	 *
	 * @param String $videoName
	 * @param String $videoType
	 *
	 * @return Bool
	 */
	public static function video($videoName, $videoType="")
	{
		// Checks if only the type has been passed
		if (empty($videoType) && in_array($videoName, ["mp4", "webm", "ogv"])) {
			// Checks the type of video
			switch ($videoName) {
				case "mp4":
					// Displays the MIME type of the video
					echo "video/mp4";
					break;

				case "webm":
					// Displays the MIME type of the video
					echo "video/webm";
					break;
				
				case "ogv":
					// Displays the MIME type of the video
					echo "video/ogg";
					break;
				
				default:
					break;
			}

			// Closes the function
			return true;
		}

		// Checks whether the type of video passed is valid
		if (empty($videoType) || !in_array($videoType, ["mp4", "webm", "ogv"])) {
			// Returns the error warning
			echo "{$videoType} é um tipo de video desconhecido";
			
			// Return false
			return false;
		}

		// Replaces periods (.) With the DIRECTORY_SEPARATOR constant
		$videoName = str_replace(".", DIRECTORY_SEPARATOR, $videoName) . ".{$videoType}";

		// Saves the complete video path
		$videoPath = VIDEO_DIR . $videoName;

		// Check if the video exists
		if (!file_exists($videoPath)) {
			// Returns the error warning
			echo "The {$videoName} file does not exist";
			
			// Return false
			return false;
		}

		// Take the content of $videoPath
		$video = file_get_contents($videoPath);

		// Save the final code of the video
		$videoSrc = "";

		// Checks the type of video
		switch ($videoType) {
			case "mp4":
				$videoSrc = "data:video/mp4;base64,";
				break;
			
			case "ogv":
				$videoSrc = "data:video/ogg;base64,";
				break;

			case "webm":
				$videoSrc = "data:video/webm;base64,";
				break;
			
			default:
				return false;
				break;
		}

		// Add the base64 string to the video code
		$videoSrc .= base64_encode($video);

		// Displays the video code
		echo $videoSrc;

		// Closes the function
		return true;
	}

	/**
	 * Convert the favicon.ico file to base64 and show the string.
	 *
	 * @return Bool true
	 */
	public static function favicon()
	{
		// Checks whether the favicon.ico file exists
		if (file_exists(FAVICON_DIR . "favicon.ico")) {
			// Save the contents of the file
			$file = file_get_contents(FAVICON_DIR . "favicon.ico"); 
			
			// Saves the final code of the file
			$fileSrc = "data:image/x-icon;base64,";

			// Adds the base64 string to the file code
			$fileSrc .= base64_encode($file);

			// Displays the file code
			echo $fileSrc;
		}

		// Closes the function
		return true;
	}

	/**  [REMOVER DA BRANCH MASTER EM 1.0.1]
	 * Displays an input with the token configured in Configuration/session.php
	 *
	 * @return Bool true
	 /
	public static function inputToken()
	{
		// Displays the token
		echo "<input type=\"text\" hidden=\"hidden\" value=\"" . $GLOBALS["token"] . "\" name=\"token\">";

		// Closes the function
		return true;
	}

	/**
	 * Displays flash session variables.
	 *
	 * @param String $sessionName
	 *
	 * @return void
	 /
	public static function sessionContent($sessionName)
	{
		// Displays the contents of a flash session
		echo $_SESSION["FLASH"][$sessionName];
	}
	*/
}

?>
