<?php defined('APP_PATH') or die('No direct script access.');

final class AC {

public static function buildTopBar($active_tab) {
  $tabs = array(
    '' => 'Home',
    'docs' => 'Docs',
    'examples' => 'Examples',
    'themes' => 'Themes',
    'download' => 'Download',
    'https://github.com/oakmac/autocompletejs' => 'GitHub',
  );

  $html  = '<div class="contain-to-grid">'."\n";
  $html .= '<div class="top-bar">'."\n";
  $html .= '<ul>'."\n";
  $html .= '  <li class="name"><h1><a href="">AutoCompleteJS</a></h1></li>'."\n";
  $html .= '</ul>'."\n";
  $html .= '<ul class="right">'."\n";
  foreach ($tabs as $link => $name) {
    $html .= '  <li class="divider"></li>'."\n";
    if ($active_tab === $name) {
      $html .= '  <li class="active"><a href="'.$link.'">'.$name.'</a></li>'."\n";
    }
    else {
      $html .= '  <li><a href="'.$link.'">'.$name.'</a></li>'."\n";
    }
  }
  $html .= '  <li class="divider"></li>'."\n";
  $html .= '</ul>'."\n";
  $html .= '</div>'."\n";
  $html .= '</div>'."\n";

  return $html;
}

// returns an array of all the examples
public static function getExamples() {
  $examples = self::getExamplesJSON();
  for ($i = 0; $i < count($examples); $i++) {
    $num = (int) $examples[$i]['number'];
    $examples[$i]['html'] = trim(file_get_contents(APP_PATH.'examples/'.$num.'.html'));
    $examples[$i]['js']   = trim(file_get_contents(APP_PATH.'examples/'.$num.'.js'));
  }
  return $examples;
}

// get the html and js file for an example
// returns false if the example does not exist
public static function getExample($number) {
  // example should be an integer
  $number = (int) $number;

  if (file_exists(APP_PATH.'examples/'.$number.'.html') !== true) {
    return false;
  }

  return array(
    'html'   => trim(file_get_contents(APP_PATH.'examples/'.$number.'.html')),
    'js'     => trim(file_get_contents(APP_PATH.'examples/'.$number.'.js')),
    'number' => $number,
  );
}

public static function getDocs() {
  return json_decode(file_get_contents(APP_PATH.'pages/docs.json'), true);
}

//---------------------------------------------------
// Private Functions
//---------------------------------------------------
private static function getExamplesJSON() {
  $examples = json_decode(file_get_contents(APP_PATH.'examples/examples.json'), true);
  $examples2 = array();
  foreach ($examples as $e) {
    if (is_array($e) !== true) continue;
    array_push($examples2, $e);
  }
  return $examples2;
}

} // end class AC

?>