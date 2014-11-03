<?php
/*
    Title: PHP CronJobs
    Version: 1.0
    Auther: Sanjay Kumar Panda
    Description: Set your scheduled programming here.
*/

class CronJob{
    
   
    //Check the give command is exist or not.
    public function cronjob_exists($command){

      $cronjob_exists=false;
      $crontab=$this->read_cron();
      if(isset($crontab)&&is_array($crontab)){
      
              $crontab = array_flip($crontab);
      
              if(isset($crontab[$command])){
      
                  $cronjob_exists=true;
      
              }
      
          }
          return $cronjob_exists;
     }
     
     // Add jobs to crontab 
     public function append_cronjob($command){
      if(is_string($command)&&!empty($command)&&$this->cronjob_exists($command)===FALSE){
          //add job to crontab
          exec('echo -e "`crontab -l`\n'.$command.'" | crontab -', $output);
      }
      return $output;
     }
   
     //read All cron settings
     public function read_cron(){
       exec('crontab -l', $crontab);
       return $crontab;
     }
   
     //Delete the selected cron job
     public function delete_cron($command=""){
      if($command!="")
      {
          $crontab=$this->read_cron();
           if(isset($crontab)&&is_array($crontab)){
      
              $crontab = array_flip($crontab);
      
              if(isset($crontab[$command])){
      
                 unset($crontab[$command]);
                 $this->deate_cron();
                 $crontab = array_flip($crontab);
                 foreach($crontab as $con){
                  $this->append_cronjob($con);
                 }
      
              }
             
      
          }
      }
      else{
          exec('crontab -r', $crontab);
          return $crontab;
      }
     }
   
     //get the sytem current user name.
     public function get_user(){
      exec('id -u -n',$op);
      return $op;
     }
   
     //Chek the system is linux or not
     public function isLinux(){     
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
          return 'notlinux';
      } else if(strpos(PHP_OS,'Linux')!==false) {
          return true;
      }
      else{
          return 'notlinux';
      }
      
     }
}

?>