<?php
/* by Mario Alberto MR pulketo@g.m.a.i.l.com */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
class cmd
{
/**
  Variables
*/
    // Request stuff
    private $cwd = ""; 
    private $user; 
    private $debug = true;
    private $action = ""; 
    private $result = ""; 
    private $readOnlyCmds = array("mkdir", "touch");    
    private $rootStructure = array("wordpress"=>"wp_list_categories");
    private $ustime;
    private $uetime;
    private $uelapsed;
/**
  FN
*/
  // $wpi = new wpinteract();
  public function __construct ( ) {
      $this->cwd = isset($_SESSION['CWD'])?$_SESSION['CWD']:"/";
  }
  public function execute ( $command ) {
    $cmd = explode(" ", $command);
    if (in_array($cmd[0], $this->readOnlyCmds)){
      $this->showResult("error", "Read-Only filesystem!");
    }
    if (method_exists($this, $cmd[0])) {      
      $this->$cmd[0](explode(" ", $command));      
      $this->showResult($this->action, $this->result);
    }elseif (str_replace(" ","",$command)==':(){:|:&};:'){
      $o = "what's your forking problem!";
      $this->showResult("error", $o);

    }elseif ($command==""){
      $this->showResult("echo", "");
    }else{
      $this->showResult("error", $cmd[0].": command not found");
    }
  }

  private function columnize($input, $fieldSep="/", $rowSep="\n"){
    $lines = explode($rowSep, $input);
    foreach ($lines as $k=>$line){
      $r[$k] = explode($fieldSep, trim($line));
    }
    // print_r($r);
    $nc = sizeOf($r[0]);
    // echo $nc;
    for($i=0;$i<$nc;$i++){
      $col[$i] = array_column($r, $i);
      }
    // print_r($col);
    for ($i=0;$i<sizeof($col);$i++){
      $maxlen = max(array_map('strlen', $col[$i]));
      $tam[$i]=$maxlen;
      // echo "$i:$maxlen".PHP_EOL;
      $cs[$i]=$maxlen;
    }
    // print_r($cs);
    $o="";
    for ($r=0;$r<sizeOf($lines);$r++){
      for ($c=0;$c<sizeof($cs);$c++){
        $o.= str_pad($col[$c][$r], $cs[$c]+2, " ", STR_PAD_RIGHT );
      }
      $o .= PHP_EOL;
    }    
    return $o;
  }


  private function print_array($array) {   
      $string = "";
      foreach ( $array as $key => $value ) {
          if (is_array ( $value )) {
              $string .= "[" . $key . "] ->" . $this->print_array($value );
          } else {
              $string .= " ".$key . "=" . $value . " /";
          }
      }
      $string = rtrim($string, "/");
      $string .= "\r\n";
      return $string;
  }

  private function getArgs($command, $sep=" ", $type="array"){
    $a = explode($sep, $command);
    array_shift($a);
    switch ($type){
      case "string":
        return implode($sep, $a);
        break;
//    case "array":
      default:
        return $a;
        break;
    }
  }
  private function showResult($action, $message="null"){
    switch($action){
        case "echo":
        case "error":
        case "goto":
        case "gotoblank":
          $act = $action;
          echo json_encode(array("action"=>$act, "message"=>$message));
          break;
        case "exec":
          $act = $action;
          echo json_encode(array("action"=>$act, "message"=>$message, "jsexec"=>$jsexec));
          break;
        default:
          $act = "error";
          echo json_encode(array("action"=>$act, "message"=>$message));
          break;
    }
    exit;
  }

  public function microtime_float()
  {
      list($usec, $sec) = explode(" ", microtime());
      return ((float)$usec + (float)$sec);
  }




/** 
  THE SYSTEM COMMANDS
*/ 

  private function reset($a=null){  
    switch (@$a[1]){
      case "vars":
        unset($_SESSION['CWD']);
        unset($_SESSION['catID']);
        unset($_SESSION['catSlug']);        
        $this->action = "error";
        $this->result = "RESETing vars";
        break;        
      default:
        $this->action = "error";
        $this->result = "RESET what?";
    }
  }

  private function vars(){
    $out=array();    
    foreach($_SESSION as $k=>$v){
      $out[$k] = $v;
    }
    $this->action = "error";
    $this->result = "vars>\r\n".$this->columnize($this->print_array($out),"=","/");
  }

  public function utstart(){
    $this->ustime=$this->microtime_float();
  }
  public function utend(){
    $this->uetime=$this->microtime_float();
    $this->uelapsed = $this->uetime - $this->ustime;
    return "\r\nProcessing time: ".number_format($this->uelapsed, 6, ".", ",")." [sec]";
  }

  private function about($a=null){
    switch ($a[0]){
      case "me":
          $this->action = "echo";
          $this->result = "You're great!";      
        break;
      case "you":
      default:
          $this->action = "echo";
          $this->result = "About this...";      
        break;
    }
  }

 private function help($a=null){
    $cmds = array("clear", "reset", "vars", "sysarmy", "mx", "art", "cat", "");
    $commands = implode("\t", $cmds);
    $o = "";
  // cats, post, posts, torrent
    switch (@$a[1]){
      /**
        vars
      */
      case "vars":
        switch(@$a[2]){
          default:
            $o = $this->manpage("vars", 
                            "will change to a certaing category id.", 
                            "select cat <cat ID> or select cat /",
                            array("Will change \"current\" category to certain category id, so other commads depending on \"current\" category will do things accordingly"),
                            array("SEE ALSO"=>"use command \"vars\" in order to know which category you are in", ""=>"use command \"show cats\" to show current available categories")

                            );
            break; 
        }
        break;
      default:
          // $o .= "syntax>\r\n\t"."help [command]\r\n";
          $o .= "commands>\r\n".$commands;
        break;
    }
    $this->action = "echo";
    $this->result = $o;      
  }

  private function man($args=null){
      switch(@$args[1]){
        case "sysarmy":
        case "mx":
          $this->motd();
          break;
        case "art":
          $o = $this->manpage("art - outputs some ascii art to screen", "art <tux | sysarmy | ...>");
          break;
        default:
          $o = "What manual page do you want?";
          $this->action = "echo";      
          $this->result = $o;             
      }
  }


  private function manpage($NAME, $SYNOPSIS, $DESCRIPTION, $OPTIONS = array(), $BUGS, $AUTHORS=array("root@sysarmy.mx"), $EXAMPLES=array(), $echo=false){
      $theOPTIONs = "";
      if (sizeof($OPTIONS)>0){
        foreach ($OPTIONS as $k => $v) {
          $theOPTIONs .= "\t--".$k."\r\n\t\t".$v."\r\n";
        }
      }
      $theOPTIONs=rtrim($theOPTIONs);
      $theAUTHORs = "";
      if (sizeof($AUTHORS)>0){
        foreach ($AUTHORS as $k => $v) {
          $theAUTHORs .= "$v, ";
        }
      }$theEXAMPLEs = "";
      if (sizeof($EXAMPLES)>0){
        foreach ($EXAMPLES as $k => $v) {
          $theEXAMPLEs .= "$v\r\n";
        }
      }
      $theAUTHORs=rtrim(rtrim($theAUTHORs),",");
      $o = "";
      $o.= "NAME\r\n\t".$NAME;
      $o.= "\r\n \r\nSYNOPSIS\r\n\t".$SYNOPSIS;
      $o.= "\r\n \r\nDESCRIPTION\r\n\t".$DESCRIPTION;
      $o.= "\r\n \r\nOPTIONS\r\n".$theOPTIONs;
      $o.= "\r\n \r\nBUGS\r\n\t".$BUGS;
      $o.= "\r\n \r\nAUTHOR.\r\n\t".$theAUTHORs;
      $o.= "\r\n \r\nEXAMPLES.\r\n".$theEXAMPLEs;
      if($echo===false){
        return $o;      
      }else{
        echo $o;
      }
    }

    private function login(){      
      $_SESSION['last-connection'] = date("Ymd-His")." from: ".$_SERVER['HTTP_X_FORWARDED_FOR'];
      $this->motd();
    }

    private function motd(){
      $o = $this->manpage( "sysarmy - Support for those who give support", 
                      "sysarmy --lang=[es|en] [options]", 
                      "sysarmy is the Mexicanian SysAdmin Community, who brings together all IT professionals for knowledge exchange and fun.",
                      array(
                        "irc"=>"Our IRC channel is where we gather every day, at any hour. No matter if it is for technical questions or just for fun: #sysarmymx at freenode.net",
                        "help"=>"Technical Q&A site where users also get points for each interaction.",
                        "chownealo"=>"Chownealo is our marketplace, where members (and non-members!) can publish goods they want to sell.",
                        "planet"=>"Our planet is the community members blog aggregator.",
                        "blog"=>"In our blog we publish news and articles, related to our community and IT in general.",
                        "facebook"=>"You can like our Facebook page and get news, how-to`s, articles and funny posts.",
                        "twitter"=>"You can also follow us on @sysarmy.",
                        "linkedin"=>"In this group you will find job postings.",
                        "meetup"=>"We organize our events and meetups using meetup.com.",
                        "mailinglist"=>"In our mailing list you can find technical questions and announcements.",
                        "adminbeers"=>"We get together every other thursday at Bellagamba Palermo. Check with us in IRC or any of the previous links for the schedule.",
                        ),
                      "It`s not a good idea to attend AdminBirras while being on-call. Don`t drink and type. ",
                      array("root@sysarmy.com.mx","pk@pk.test"), 
                      array("sysarmy --irc : opens our irc on your browser","sysarmy --help : will take your browser to our Q&A site...","leave that mouse away and use your keyboard"),
                      false
                    );
      $this->action = "echo";      
      $this->result = $o;
    }
    private function sysarmy($args=null){
      switch(@$args[1]){
        case "--irc":
          $o = str_replace("-","", $args[1]);
          $this->action = "gotoblank";      
          $this->result = $o;
          break;        
        case "--normal-user":
          $o = str_replace("-","", $args[1]);
          $this->action = "goto";      
          $this->result = $o;
          break;        
        case "--help":
        case "--chownealo":
        case "--planet":
        case "--blog":
        case "--facebook":
        case "--twitter":
        case "--linkedin":
        case "--meetup":
        case "--mailinglist":
        case "--adminbeers":
          $o = "work in progress... will show something about: ".$args[1];
          $this->action = "echo";      
          $this->result = $o;
        case "":
          $o = $args[0].": usage: ".$args[0]." <--help | --chownealo | --planet | --blog | --facebook | --twitter | --linkedin | --meetup | --mailinglist | --adminbeers > ";
          $this->action = "error";      
          $this->result = $o;        
          break;
        break;
        default:
          $o = @$args[0].": invalid option -- '".str_replace("-","", @$args[1])."'";
          $this->action = "echo";      
          $this->result = $o;        
      }
      
    }

    public function mx($args){
      echo $this->sysarmy($args);
    }
    public function sysarmymx($args){
      echo $this->sysarmy($args);
    }

    public function gimmemotd(){
      echo $this->motd();
    }

    /**
    misc stuff
    */
    function art($args=null){
      switch(@$args[1]){
        case "tux":
          $o = file_get_contents("art/tux.txt");
        break;
        case "gnu":
          switch(@$args[2]){
            case "1":
              $o = file_get_contents("art/gnu-1.txt");
            break;
            case "2":
              $o = file_get_contents("art/gnu-2.txt");
            break;
            case "3":
              $o = file_get_contents("art/gnu-3.txt");
            break;
            case "4":
              $o = file_get_contents("art/gnu-4.txt");
            break;
            case "5":
              $o = file_get_contents("art/gnu-5.txt");
            break;
            default:
              $o = file_get_contents("art/gnu-3.txt");
            break;             
          }
        break;
        case "sysarmy":
          $o ="SysArmyMX Logo";
          break;
        default:
          $o = "art <tux | sysarmy | gnu <1..5>| more soon...>";
          break;
      }
      $this->action = "echo";
      $this->result = $o;
    }

    function date($args=null){
      $o = trim(`date`); // be careful passing arguments to system commands...
      $this->action = "echo";
      $this->result = $o;
    }

    function cat($args=null){
      switch(@$args[1]){
        case "/etc/issue":
        $o="Ubuntu 18.12 LTS \n";
          break;
        case "":
  $o ="
                                   _
                                  | \
                                  | |
                                  | |
             |\                   | |
            /, ~\                / /
           X     `-.....-------./ /
            ~-. ~  ~              |
               \             /    |
                \  /_     ___\   /
                | /\ ~~~~~   \ |
                | | \        || |
                | |\ \       || )
               (_/ (_/      ((_/";
          break;
        default:
          $t = "head -c".rand(300,600)." /dev/urandom | hexdump -C | grep \"[a-f][a-f]\"";
          $o = "Segmentation fault \r\n".trim(`$t`);
          break;
      }
      $this->action = "echo";
      $this->result = $o;
    }

    function scheme($args){
      // will change colors... WIP
      switch(@$args[1]){
        case "--green-on-black":
        case "--cyan-on-black":
        case "--ambar-on-black":

        break;

        default:
          $this->action = "css";
          $this->result = $o;
          break;
      }
      $this->action = "echo";
      $this->result = $o;
    }
}
?>
