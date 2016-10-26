<?php

/**
 A class that writes html either into a local buffer or directly to the output. Freely distributable as long as this header is kept at the top of the file and not modified.

 @author Jean-Georges Estiot <jgestiot@gmail.com>
 @version 2.0

 */
class html
	{
	static private $spaces_per_indent;
	static private $stack;
	static private $attributes;
	static private $indent_level;
	static private $buffer;
	static private $buffered;


	/**
	 init() must be called once before the class is used by the application. It sets up the indent, defaults to buffered output and calls reset().

	 @param int $spaces The number of spaces to use in the indentation

	 @return void does not return anything
	 */
	
	static public function init($spaces = 2) 
		{
		self::$spaces_per_indent = $spaces;
		self::$buffered = true;
		self::reset();
		}



	/**
	 Resets some of the key elements of the class: the stack, the indent, the attributes and the buffer.

	 @return void does not return anything
	 */

	static public function reset() 
		{
		self::$stack = array();
		self::$indent_level = 0;
		self::clear_attributes();
		self::clear_buffer();
		}



	/**
	 * Returns the content of the buffer

	 @return string The content of the buffer.
	 */

	static public function get_buffer() 
		{
		$temp = self::$buffer;
		self::clear_buffer();
		return $temp;
		}



	/**
	 *clears the buffer

	 @return void does not return anything
	 */
	static private function clear_buffer() 
		{
		self::$buffer = '';
		}



	/**
	 Sets the buffering to true or false. If false, the class will output the tags immediately. If true, it will keep all content into the buffer for later use.

	 @param bool $how True for buffered and false for unbuffered.

	 @return void does not return anything
	 */

	static public function set_buffered($how) 
		{
		self::$buffered = $how;
		}



	/**
	 Writes a string to the buffer. This is the only function in the class that outputs. If $indent is set to true, the string output is correctly indented, relative to other code.

	 @param string $string The string to write to output
	 @param bool $indent True to indent the string or false otherwise

	 @return void does not return anything
	 */
	
	static public function write($string, $indent = false) 
		{
		
		if ($indent) $string = self::make_indent() . $string;
		if (self::$buffered) self::$buffer.= $string;
		else
			{
			echo $string;
			}
		}



	/**
	 Adds a single attribute to the next tag. Example for an `<input>` tag: add_attribute('type','checkbox');

	 @param string $name The name of the attribute
	 @param string $value The value of the attribute

	 @return void does not return anything
	 */
	
	static public function add_attribute($name, $value) 
		{
		
		self::$attributes[$name] = $value;
		}



	/**
	 Adds more than one attribute to the next tag
	 The attributes for the tag are passed in the format array('attribute'=>'value'). 	 So array('id'=>'tag_id','class'=>'myclass') would produce this div tag:
	 `<div id=tag_id" class="myclass">`

	 @param array $ar The array holding the attributes

	 @return void does not return anything
	 */
	
	static public function add_attributes($ar) 
		{
		
		if (is_array($ar)) 
			{
			
			self::$attributes = array_merge(self::$attributes, $ar);
			}
		}



	/**
	 Outputs the attributes for the tag that were added with add_attribute() or add_attributes().

	 Example: if the previously-added attributes are array('id'=>'tag_id','class'=>'myclass'),  expand_attributes() will
	 produce the string 'id=tag_id" class="myclass'.
	 Important: all attributes are cleared once the string is output.

	 @return void does not return anything
	 */
	
	static private function expand_attributes() 
		{
		
		foreach (self::$attributes as $idx => $val) 
			{
			self::write(' ' . $idx . '=' . '"' . $val . '"');
			}
		
		self::clear_attributes(); //always clear attributes when finished
		
		
		}



	/**
	 Clears all attributes. (The next tag will have no attributes)

	 @return void does not return anything
	 */
	
	static public function clear_attributes() 
		{
		
		self::$attributes = array();
		}



	/**
	 Generates a tag. There are three flavours:

	 1) Open tags with no close and no content. Just the attributes if required: `<div class="myclass">`. This tag will require a call to close()

	 2) Tags that never require a close such as `<img href="image.jpg">`

	 3) Tags that have content and are immediately terminated on the same line `<title>Hello</title>`

	 For the first, use tag('div');

	 For the second, use tag('img',false,false) or the function single_tag()

	 For the third, simply pass the tag's content like so: tag('title','Hello')

	 @param string $tag The name of the tag. For example 'div' for the `<div>` tag
	 @param mixed $content A string for tags such as `<title>string</title>`
	 @param bool $push A flag indicating if the tag should be pushed onto the stack

	 @return void does not return anything
	 */

	static public function tag($tag, $content = null, $push = true) 
		{
		$has_content = !is_null($content); // the content can be an empty string
		
		if ($push) 
			{
			array_push(self::$stack, $tag);
			}
		
		self::indent();
		self::write('<' . $tag);
		self::expand_attributes();
		self::write('>');
		
		if ($push) self::$indent_level++;
		
		if ($has_content) self::write($content);
		
		if (!$has_content) self::write("\n");
		
		if ($push && $has_content) 
			{
			self::close(false);
			}
		}



	/**
	 Outputs a single tag such as `<img>` or `<input>`. Single tags do not require a closing tag.

	 @param string $tag The name of the tag. For example 'input' for an `<input>` tag

	 @return void does not return anything

	 */

	static public function single_tag($tag) 
		{
		self::tag($tag, null, false);
		}



	/**
	 Closes the last opened tag. if $indent is set to false, there is no indentation, which is useful for tags where the open and close are on the same line like `<title>Title</title>`

	 @param bool $indent A flag controlling the indent. True for using indent

	 @return void does not return anything
	 */

	static public function close($indent = true) 
		{
		
		$tag = array_pop(self::$stack);
		
		self::$indent_level--;
		if ($indent) self::indent();
		self::write('</' . $tag . ">\n");
		}



	/**
	 Returns the padding needed to indent a tag or string of text

	 @return void does not return anything
	 */
	
	static private function make_indent() 
		{
		
		return str_repeat(' ', self::$indent_level * self::$spaces_per_indent);
		}



	/**
	 * Performs the indentation by writing the padding returned by make_indent() to the output.

	 @return void does not return anything
	 */

	static private function indent() 
		{
		if (self::$indent_level > 0) self::write(self::make_indent());
		}



	/**
	 Appends some arbitrary code to the buffer or ouputs it after applying the current indent level before the code and each time a newline is found.

	 If properly indented code is passed, it will be appended and properly indented into the existing html code.

	 A newline is inserted after the code.

	 @param string $code The code to be appended

	 @return void does not return anything
	 */

	static public function insert_code($code) 
		{
		
		$indent_factor = "\n" . self::make_indent();
		
		self::indent();
		$code = str_replace("\n", $indent_factor, $code);
		
		self::write($code . "\n");
		}



	/**
	 Shortcut function to write a `<br>` to the buffer

	 @return void does not return anything
	 */

	static public function br() 
		{
		self::write('<br>');
		}



	/**
	 Shortcut function to write a newline `\n` to the buffer

	 @return void does not return anything
	 */

	static public function nl() 
		{
		self::write("\n");
		}



	/**
	 Shortcut function to write both `<br>` and `\n` to the buffer
	 
	 @return void does not return anything
	 */

	static public function brnl() 
		{
		self::br();
		self::nl();
		}

	} // Ends html Class


?>