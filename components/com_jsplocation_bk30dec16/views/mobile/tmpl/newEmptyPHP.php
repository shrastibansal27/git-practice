
<img src= '<?php echo JURI::base(); ?>images/jsplocationimages/jsplocationImages/<?php echo $image_name; ?>' width = "100%" height='<?php echo $configParams[0]->height;?>' />

 <?php echo 'shrasti'.JURI::base().'/'.'images'.'/'.'jsplocationimages'.'/'.'jsplocationImages'.'/'; ?>



	<div class="jsp_head" style="font-weight:500">
        	<div class="info_title">
        		<?php echo $this->description[0]->branch_name; ?>
        	</div>
        </div>
<div class="address">
                            <p style="color:#000;font-size: 17px !important;"><?php echo $this->branchdetails[0]->address1; ?></p>
							<p><?php echo $this->getCityName[0]->title; ?> - <?php echo $this->branchdetails[0]->zip; ?></p>
                    	</div>


                	<div class="info_one">
                    	
                        <?php if($this->branchdetails[0]->contact_number != ''){ ?>
                       <div class="phn_no">
                        
                         <?php    echo "<p>Call - ".$this->branchdetails[0]->contact_number."</p>"; ?>
                           
                       </div>
                        <?php } ?>

						
                	</div>

          <div class="info_two">
                        <p class="branch_hrs">Additional Information</p></br>
                       <?php if($this->branchdetails[0]->contact_person != '' && $this->getDefaultFieldStatus[0]->published != 0){ if($this->branchdetails[0]->gender == 0){ $gender = "Male"; } else{  $gender = "Female"; } echo "<p>Contact Person - ".$this->branchdetails[0]->contact_person."</p>"; if($this->getDefaultFieldStatus[1]->published != 0) echo"<br/><p>Gender - ".$gender."</p>"; } ?>
                       <?php if($this->branchdetails[0]->email != '' && $this->getDefaultFieldStatus[2]->published != 0){ echo "<br/><p>E-Mail - <a href='mailto:".$this->branchdetails[0]->email ."' target='_top'>".$this->branchdetails[0]->email."</a></p>"; } ?>
					   <?php if($this->branchdetails[0]->website != '' && $this->getDefaultFieldStatus[3]->published != 0){ echo "<br/><p>Website - <a target='_blank' href='".$this->branchdetails[0]->website ."'>".$this->branchdetails[0]->website."</a></p>"; } ?> 
					   
					   <?php if($this->branchdetails[0]->facebook != ''){ echo "<br/><p>Facebook - <a target='_blank' href='".$this->branchdetails[0]->facebook ."'>".$this->branchdetails[0]->facebook."</a></p>"; } ?> 
					   <?php if($this->branchdetails[0]->twitter != ''){ echo "<br/><p>Twitter - <a target='_blank' href='".$this->branchdetails[0]->twitter ."'>".$this->branchdetails[0]->twitter."</a></p>"; } ?> 
					   <?php if($this->branchdetails[0]->additional_link != ''){ echo "<br/><p>Additional link - <a target='_blank' href='".$this->branchdetails[0]->additional_link ."'>".$this->branchdetails[0]->additional_link."</a></p>"; } ?> 
					   <?php if($this->branchdetails[0]->description != '' && $this->getDefaultFieldStatus[4]->published != 0){ echo "<br/><p>Description - ".$this->branchdetails[0]->description ."</p>"; } ?> 
					   
					   <?php if($this->customNames != '' && $this->customValues !=''){
							$i=0;
							 foreach ($this->customNames as $key => $value) { 	
							 
							 echo"<br/><p>".$this->customNames[$i] ." - ".$this->customValues[$i] ."</p></br>";
							
							 $i++;
							 }
							 
					   }
					   ?>
					  
                    </div>

<div class="info_title"><?php echo $branchname;?> Media</div>