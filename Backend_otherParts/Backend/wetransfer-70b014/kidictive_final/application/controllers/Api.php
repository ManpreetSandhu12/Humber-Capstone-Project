<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 


	/** Function to send email **/

	public function emailsend($email)
    {
        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        $this->email->to($email['to']);
        $this->email->from('your-name@gmail.com');
        $this->email->subject($email['subject']);
        $this->email->message($email['message']);
        $this->email->send();
    }
	
	/** Signup Api **/

	public function signup()
	{
        if($this->input->get_post('email') && $this->input->get_post('birth_year') && $this->input->get_post('password') )
        {
        	$date1 = $this->input->get_post('birth_year');

			$date2 = date("Y");

			$diff = $date2 - $date1;

			if($diff >= 13){

	            $user_exist= $this->users->select_where('parents',array('email' => $this->input->get_post('email')));
	            if($user_exist->num_rows()==0)
	            {
	                $password=  $this->input->get_post('password');
					$birth_year= $this->input->get_post('birth_year');
	                $password= md5($password);
	                
	                $post_data = array(
		                            'birth_year'   =>  $this->input->get_post('birth_year'),
		                            'email'   =>  $this->input->get_post('email'),
		                            'password'   =>  $password,
		                            'platform'   =>  $this->input->get_post('platform'),       
		                            'device_id'   =>  $this->input->get_post('device_id'),
		                            'notification_id'   =>  $this->input->get_post('notification_id'),
		                            'status' => 1,
	                        	);
	                          
	                
	                $insert_id= $this->users->Insert_data('parents',$post_data);  // Insert data to userid In user table
	                if($insert_id !=0)
	                {
	                    $result= $this->users->select_where('parents',array('id' => $insert_id));
	                    foreach ($result->result() as $row)
	                    {
	                        $data['parent_id']=$row->id;
	                        $data['email']=$row->email;
	                    }

	                    $re=array(
	                           'status'=>1,
	                            'data'=>$data,    
	                            'msg'=>'Success'
	                        );  

	                }else{
	                    $re=array(
	                    		'status'=>0,
	                    		'msg'=>'Please Try again'
	                    	);
					}
		        }else{
	                $re=array(
	                	'status'=>0,
	                	'msg'=> "User already exist"
	                );
	            }
	        }else{
	        	$re=array(
                	'status'=>0,
           	   	 	'msg'=>"Your are under 13. You can't signup."
           		);
	        }
        }else{
            $re=array(
                'status'=>0,
           	    'msg'=>'Requried field is missing'
           	);
        }
                
        $this->output
                ->set_content_type('application/json') 
                ->set_output(json_encode($re));
	}

	
	/** About Family Api **/ 

	public function family_info()
    {
        if( $this->input->get_post('first_name') && $this->input->get_post('last_name') && $this->input->get_post('parent_id') 
			&& $this->input->get_post('relationship') && $this->input->get_post('child_first_name') && $this->input->get_post('child_last_name') 
			&& $this->input->get_post('birth') && $this->input->get_post('username') && $this->input->get_post('password'))
        {	

        	////////////Image Upload code////////////////////
            if (!empty($_FILES['parent_pic']['name']))
            {
                $config['upload_path'] =  './assets/images/profile_pic/parent/'; 
                              
                $new_name = time(). $this->input->get_post('parent_id');
                $config['file_name'] = $new_name;
                $config['overwrite'] = TRUE;
                $config["allowed_types"] = 'jpg|jpeg|png|gif';
                                                 
                $this->load->library('upload', $config);

                if(!$this->upload->do_upload('parent_pic')) 
                {       
					echo $this->data['error'] = $this->upload->display_errors();
                } else {
                    $file_name = $_FILES["parent_pic"]['name'];
                    $ext = explode('.',$file_name);
                                                
                    $update_image = array(
                                        'profile_pic' => 'images/profile_pic/parent/'. $new_name.'.'.$ext[1],
                                    );
                    
                    $condition = array(
                                 	'id' => $this->input->get_post('parent_id')
                                );
                    
                    $image_update= $this->users->update_where('parents',$update_image,$condition);                                           
                } 
            }

			$update_data = array(
								'first_name'   =>  $this->input->get_post('first_name'),       
                                'last_name'   =>  $this->input->get_post('last_name'),
                                'relationship'   =>  $this->input->get_post('relationship'),
                            );
                    
                    $condition = array(
                                 	'id' => $this->input->get_post('parent_id')
                                );
                    
                    $device_update= $this->users->update_where('parents',$update_data,$condition);

					
					
                    $parent_id = $this->input->get_post('parent_id');
                    
                           
                $user_exist= $this->users->countRow('child',$parent_id);
				if($user_exist->num_rows() >= 5){
					$re=array(
							'status'=>0,
							'msg'=>'You can add maximum 5 childs'
						);
				}else{
					
					$user_exist= $this->users->select_where('child',array('username' => $this->input->get_post('username'), 
																			'parent_id' => $this->input->get_post('parent_id')));
					if($user_exist->num_rows()==0)
					{
						$password =  $this->input->get_post('password');
						$password= md5($password);
	                
						$post_data = array(
									'parent_id'   =>  $this->input->get_post('parent_id'),
		                            'first_name'   =>  $this->input->get_post('child_first_name'),
		                            'last_name'   =>  $this->input->get_post('child_last_name'),
									'birthday' => $this->input->get_post('birth'),
									'username' => $this->input->get_post('username'),
		                            'password'   =>  $password,
		                            'status' => 1,
	                        	);
	                          
	                
						$insert_id= $this->users->Insert_data('child',$post_data);  // Insert data to users In child table
						if($insert_id !=0)
						{
							////////////Image Upload code////////////////////
				            if (!empty($_FILES['child_pic']['name']))
				            {

				                $config['upload_path'] =  './assets/images/profile_pic/child/'; 
				                          
				                $new_image = time(). $insert_id;
				                $config['file_name'] = $new_image;
				                $config['overwrite'] = TRUE;
				                $config["allowed_types"] = 'jpg|jpeg|png|gif';
				                                                 
				                $this->load->library('upload', $config);
				                $this->upload->initialize($config);

				                if(!$this->upload->do_upload('child_pic')) 
				                {       
									echo $this->data['error'] = $this->upload->display_errors();
				                } else {
				                    $file_name = $_FILES["child_pic"]['name'];
				                    $ext = explode('.',$file_name);
				                                                
				                    $update_image = array(
				                                        'profile_pic' => 'images/profile_pic/child/'. $new_image.'.'.$ext[1],
				                                    );
				                    
				                    $condition = array(
				                                 	'id' => $insert_id
				                                );
				                    
				                    $image_update= $this->users->update_where('child',$update_image,$condition);                                           
				                } 
				            }

							$result= $this->users->select_where('child',array('id' => $insert_id));
							foreach ($result->result() as $row)
							{
								$imagepath= base_url('assets/'.$row->profile_pic);
								$data['parent_id']=$row->parent_id;
								$data['child_first_name']=$row->first_name;
								$data['child_last_name']=$row->last_name;
								$data['birth']=$row->birthday;	
								$data['child_pic']= $imagepath;

							}

							$re=array(
									'status'=>1,
									'data'=>$data,    
									'msg'=>'Success'
								);              
						}else{
							$re=array(
								'status'=>0,
								'msg'=>'Please try again'
							);
						}
					}else{
						$re=array(
								'status'=>0,
								'msg'=> "User already exist"
							);
					}
				}
		}else{
            $re=array(
					'status'=>0,
					'msg'=>'Requried field is missing'
				);
        }
                
		$this->output
            ->set_content_type('application/json') 
            ->set_output(json_encode($re));
    }
	
	
	/** Login Api **/ 
	
	public function login()
    {
        if( $this->input->get_post('email') && $this->input->get_post('password') && $this->input->get_post('login_type'))
        {
        	if($this->input->get_post('login_type') == 'parent'){
           		if( $this->input->get_post('platform') && $this->input->get_post('device_id')&& $this->input->get_post('notification_id'))
                {
                    $update_data = array(
										'platform'   =>  $this->input->get_post('platform'),       
                                    	'device_id'   =>  $this->input->get_post('device_id'),
                                    	'notification_id'   =>  $this->input->get_post('notification_id'),
                                    );
                    
                    $condition = array(
                                 	'email' => $this->input->get_post('email')
                                );
                    
                    $device_update= $this->users->update_where('parents',$update_data,$condition);
                           
                }

             	$login_data= array(
             						'email' => $this->input->get_post('email'),
                  					'password' => md5($this->input->get_post('password')),
                  					'status' =>1
                  				);
              
              	$login_exist= $this->users->select_where('parents',$login_data);
              
              
                if($login_exist->num_rows()!=0)
                {
                    foreach ($login_exist->result() as $row)
                    {
                        $imagepath= base_url('assets/'.$row->profile_pic);
                        $data['parent_id']=$row->id;
                        $data['first_name']=$row->first_name;
                        $data['last_name']=$row->last_name;
                        $data['email']=$row->email;
                        $data['image']= $imagepath;
                        $data['device_id']=$row->device_id;
                        $data['platform']=$row->platform;  
                        $data['notification_id']=$row->notification_id;
                    }
                                     
                    $re=array(
                            'status'=>1,
                            'data'=>$data,    
                            'msg'=>'Success'
                        );  
                }else{
                        $re=array(
                            'status'=>0,
                            'msg'=>'Please enter correct email/password'
                        );
                    }
            }else{
            	$update_data = array(
										'platform'   =>  $this->input->get_post('platform'),       
                                    	'device_id'   =>  $this->input->get_post('device_id'),
                                    	'notification_id'   =>  $this->input->get_post('notification_id'),
										'latitude'   =>  $this->input->get_post('latitude'),
										'longitude'   =>  $this->input->get_post('longitude')
                                    );
                    
                    $condition = array(
                                 	'username' => $this->input->get_post('email')
                                );
                    
                    $device_update= $this->users->update_where('child',$update_data,$condition);

             	$login_data= array(
             						'username' => $this->input->get_post('email'),
                  					'password' => md5($this->input->get_post('password')),
                  					'status' =>1
                  				);
              
              	$login_exist= $this->users->select_where('child',$login_data);
              
              
                if($login_exist->num_rows()!=0)
                {
                    foreach ($login_exist->result() as $row)
                    {

                    	$parent = array(
             						'id' => $row->parent_id,
                  				);

                    	$parent_data= $this->users->select_where('parents',$parent);
                    	foreach($parent_data->result() as $row1){

	                        $imagepath= base_url('assets/'.$row->profile_pic);
	                        $data['child_id']=$row->id;
	                        $data['parent_id']=$row->parent_id;
	                        $data['parent_first_name'] = $row1->first_name;
	                        $data['parent_last_name'] = $row1->last_name;
	                        $data['first_name']=$row->first_name;
	                        $data['last_name']=$row->last_name;
	                        $data['image']= $imagepath;
	                        $data['device_id']=$row->device_id;
	                        $data['platform']=$row->platform;  
	                        $data['notification_id']=$row->notification_id;
							$data['latitude']=$row->latitude;
							$data['longitude']=$row->longitude;
							
							$video_con = array(
             						'parent_id' => $row->parent_id,
									'child_id' => $row->id,
                  				);
							
							$videos = $this->users->select_where('video',$video_con);
							if($videos->num_rows() != ''){
								foreach($videos->result() as $video_row){
									
									$videopath = base_url('assets/'.$video_row->video);
									$data1['video_url'] = $videopath;
									
									$data_video[] = $data1;
								}
							}else{
								$data_video = '';
							}
	                    }
                    }
                                     
                    $re=array(
                            'status'=>1,
                            'data'=>$data, 
							'videos' =>$data_video,
                            'msg'=>'Success'
                        );  
                }else{
                        $re=array(
                            'status'=>0,
                            'msg'=>'Please enter correct username/password'
                        );
                    }
			}
		}else{
                $re=array(
						'status'=>0,
						'msg'=>'Requried field is missing'
					);
            }
                
		$this->output
            ->set_content_type('application/json') 
            ->set_output(json_encode($re));
    }


    /** Child List Api **/

    public function child_list()
    {
        if( $this->input->get_post('parent_id'))
        {
        	
            $condition= array(
            				'parent_id' => $this->input->get_post('parent_id')
               			);
              
            $child_list= $this->users->select_where('child',$condition);
			if($child_list->num_rows() != 0){
				foreach($child_list->result() as $row){

					$imagepath = base_url('assets/'.$row->profile_pic);
					$data['child_id'] = $row->id;
					$data['child_first_name'] = $row->first_name;
					$data['child_last_name'] = $row->last_name;
					$data['birth'] = $row->birthday;
					$data['latitude'] = $row->latitude;
					$data['longitude'] = $row->longitude;
					$data['profile_pic'] = $imagepath;

					$data1[] = $data;	
				}
				$re=array(
                    'status'=>1,
                    'data'=>$data1,    
                    'msg'=>'Success'
                ); 
			}else{
				$re=array(
                    'status'=>0,   
                    'msg'=>'No child found'
                );
			}

            
        }else{
                $re=array(
						'status'=>0,
						'msg'=>'Requried field is missing'
					);
            }
                
		$this->output
            ->set_content_type('application/json') 
            ->set_output(json_encode($re));
    }


    /** Forgot Password Api **/

    public function forgot_password()
    {
    	if( $this->input->get_post('email'))
        {
            $email_data= array('email' => $this->input->get_post('email'));
            $email_exist= $this->users->select_where('parents',$email_data);
              
            if($email_exist->num_rows()!=0)
            {
                foreach ($email_exist->result() as $row)
                {
                    $user_id=$row->id;
                }

                $random=$this->users->generatePIN();
                $otp_data= array('user_id' => $user_id);
                $otp_exist= $this->users->select_where('otp',$otp_data);
                        
                if($otp_exist->num_rows()!=0)
                {
                    $update_data= array(
                       				'otp' => $random,
                       				'status' =>1
                          		);

                    $con= array('user_id' => $user_id);

                    $update_exist= $this->users->update_where('otp',$update_data,$con);
                        
                }else{
					$otp_idata= array(
                       				'user_id' => $user_id,
                       				'otp' => $random,
                       				'status' =>1,
                       			);
                    
                    $insert_otp= $this->users->Insert_data('otp',$otp_idata);
                }
                              
                              
               	$email= array();
                $email['to']=$this->input->get_post('email');
               	$email['subject']='Reset your password for your Kidictive account';
                $email['message']="Your otp code is ".$random;
                $this->emailsend($email);
				
				$data['otp'] = $random;
				$data['user_id'] = $user_id;
                                    
                $re=array(
                  	    'status'=>1,
						'data' => $data,
             	        'msg'=>'Otp is send to your email'
                    );
            }else{
            	$re=array(
                		'status'=>0,
                    	'msg'=>'Email does not exist'
                    );
            }
       	}else{
            $re=array(
                   	'status'=>0,
                   	'msg'=>'Email is requried'
              	);
        }
                
        $this->output
            ->set_content_type('application/json') 
          	->set_output(json_encode($re));
    }


    /** Verify Otp sent on email **/

    public function verify_otp()
    {
        if($this->input->get_post('user_id') && $this->input->get_post('otp') )
        {
            
            $otp_exist= $this->users->select_where('otp',array('user_id' => $this->input->get_post('user_id'),'otp' => $this->input->get_post('otp')));
            
            if($otp_exist->num_rows()!=0)
            {
                $update_data = array(
                                    'status' => 0,
                                );
                $condition = array(
                                 	'user_id' => $this->input->get_post('user_id')
                            );
                
                $otp_update= $this->users->update_where('otp',$update_data,$condition);
                         
                $re=array(
                        'status'=>1,
                        'msg'=>'Otp is verified'
                    );

            }else{
                $re=array(
                	    'status'=>0,
                        'msg'=>'Please enter correct otp'
                    );
            }
        }else{
            $re=array(
                    'status'=>0,
                    'msg'=>'Requried field is missing'
                );
        }
             
        $this->output
                ->set_content_type('application/json') 
                ->set_output(json_encode($re));
    }
         


    /** Change Forgot password **/
    public function change_password()
    {
        if($this->input->get_post('user_id') && $this->input->get_post('password') )
        {
        	$user_id=$this->input->get_post('user_id');
            $password=$this->input->get_post('password');
            $password= md5($password);
            
            $update = array(
                        'password' => $password,
                    );
            
            $con = array(
                        'id' => $user_id
                    );
                                                   
            $pass_update= $this->users->update_where('parents',$update,$con);
                                                   
            $result= $this->users->select_where('parents',array('id' => $user_id));
            foreach ($result->result() as $row)
            {
                $imagepath= base_url('assets/'.$row->profile_pic);
                $data['parent_id']=$row->id;
                $data['first_name']=$row->first_name;
                $data['last_name']=$row->last_name;
                $data['email']=$row->email;
                $data['image']=$imagepath;
            }
                                    
            $re=array(
                    'status'=>1,
                    'data'=>$data,    
                    'msg'=>'Password Changed successfully'
                );
        }else{
            $re=array(
                    'status'=>0,
                    'msg'=>'Requried field is missing'
                );
        }
             
       	$this->output
                ->set_content_type('application/json') 
                ->set_output(json_encode($re));
    }


    /** Logout Api **/

    public function logout()
    {
        if($this->input->get_post('user_id') && $this->input->get_post('type'))
        {
        	$update_data = array(
	                            'notification_id' => "",
	                        );


	        $condition = array(
	                       'id' => $this->input->get_post('user_id')
	                    );

        	if($this->input->get_post('type') == 'parent'){    

	            $update= $this->users->update_where('parents',$update_data,$condition);

	        }else{

	        	$update= $this->users->update_where('child',$update_data,$condition);
	        
	        }
	            
	            $re=array(
	                    'status'=>1,
	                    'msg'=>'Logout successfully'
	                );
        }else{
            $re=array(
                'status'=>0,
                'msg'=>'Requried field is missing'
            );
        }
             
        $this->output
                ->set_content_type('application/json') 
                ->set_output(json_encode($re));
    }
	
	/** Add Video Api **/
	
	 public function add_video()
    {
        if($this->input->get_post('child_id') && $this->input->get_post('parent_id'))
        {
			$child_id = $this->input->get_post('child_id');
			$parent_id = $this->input->get_post('parent_id');
			
			$video_exist= $this->users->countVideoRow('video', $parent_id, $child_id);
			if($video_exist->num_rows() < 4)
			{
				////////////Video Upload code////////////////////
				if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != '')
				{
										unset($config);
					$configVideo['upload_path'] = './assets/video/';
					$configVideo['max_size'] = '60000';
					$configVideo['allowed_types'] = 'avi|flv|wmv|mp4|3gp|mp3|3gpp';
					$configVideo['overwrite'] = FALSE;
					$configVideo['remove_spaces'] = TRUE;
					$video_name = time().$this->input->get_post('parent_id');;
					$configVideo['file_name'] = $video_name;
					
					$this->load->library('upload', $configVideo);
					$this->upload->initialize($configVideo);
					if(!$this->upload->do_upload('video')) {
						echo $this->data['error'] = $this->upload->display_errors();
					}else{
						
						$videoDetails = $this->upload->data();
						$file_name = $_FILES["video"]['name'];
						$ext = explode('.',$file_name);
						
						$insert_video = array(
											'child_id'   =>  $this->input->get_post('child_id'),
											'parent_id'   =>  $this->input->get_post('parent_id'),
											'video' => 'video/'. $video_name.'.'.$ext[1],
											'status' => 1
										);
						
						$video_add= $this->users->Insert_data('video',$insert_video); 
						if($video_add !=0)
						{
							$result= $this->users->select_where('video',array('id' => $video_add));
							foreach ($result->result() as $row)
							{
								$videopath= base_url('assets/'.$row->video);

								$data['video_id']=$row->id;
								$data['child_id']=$row->child_id;
								$data['video']= $videopath;
							}

							$re=array(
									'status'=>1,
									'data'=>$data,    
									'msg'=>'Success'
								);  
						}else{
							$re=array(
									'status'=>0,
									'msg'=>'Please Try again'
								);
						}
					} 
				}
			}else{
				$re=array(
						'status'=>0,
						'msg'=>'You can add maximum 4 videos'
					);
			}
		}else{
                $re=array(
						'status'=>0,
						'msg'=>'Requried field is missing'
					);
            }
			
		$this->output
            ->set_content_type('application/json') 
            ->set_output(json_encode($re));
              
    }

}

?>
