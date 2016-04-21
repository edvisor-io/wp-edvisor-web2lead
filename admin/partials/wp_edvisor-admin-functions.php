<?php

function wp_edvisor_template($options, $input, $num) {
  $valid = array();

  // Constants
  $valid['firstname']['name'] = 'First Name';
  $valid['lastname']['name'] = 'Last Name';
  $valid['email']['name'] = 'Email';
  $valid['phone']['name'] = 'Phone';
  $valid['gender']['name'] = 'Gender';
  $valid['birthdate']['name'] = 'Birthdate';
  $valid['address']['name'] = 'Address';
  $valid['currentLocationGooglePlaceId']['name'] = 'City, Province/Region';
  $valid['postalCode']['name'] = 'Postal Code/Zip Code';
  $valid['nationalityId']['name'] = 'Nationality';
  $valid['passportNumber']['name'] = 'Passport Number';
  $valid['studentLocationPreferences']['name'] = 'Destinations';
  $valid['studentSchoolPreferences']['name'] = 'Schools';
  $valid['studentCoursePreferences']['name'] = 'Programs/Courses';
  $valid['startDay']['name'] = 'Start Day';
  $valid['startMonth']['name'] = 'Start Month';
  $valid['startYear']['name'] = 'Start Year';
  $valid['durationWeekAmount']['name'] = 'Duration';
  $valid['accommodation']['name'] = 'Accommodation';
  $valid['hoursPerWeek']['name'] = 'Hours Per Week';
  $valid['amOrPm']['name'] = 'Am or Pm';
  $valid['budget']['name'] = 'Budget';
  $valid['notes']['name'] = 'Notes';

  /* Agency ID & API KEY & FORM NAME*/
  $valid['agencyId'] = (isset($input[$num]['agencyId']) && !empty($input[$num]['agencyId'])) ? sanitize_text_field($input[$num]['agencyId']) : '';
    if (empty($input[$num]['agencyId'])) {
      add_settings_error( 'Agency Id','1','Please Enter an Agency Id' );
    }

  $valid['apiKey'] = (isset($input[$num]['apiKey']) && !empty($input[$num]['apiKey'])) ? sanitize_text_field($input[$num]['apiKey']) : '';
    if (empty($input[$num]['apiKey'])) {
      add_settings_error( 'API Key','2','Please Enter an API Key' );
    }

  $valid['formName'] = (isset($input[$num]['formName']) && !empty($input[$num]['formName'])) ? sanitize_text_field($input[$num]['formName']) : '';
    if (empty($input[$num]['formName'])) {
      add_settings_error( 'Form Name','3','Please Enter a Form Name' );
    }

  $fieldArr = array(
    'firstname', 'lastname', 'email', 'phone', 'gender', 'birthdate', 'address', 'currentLocationGooglePlaceId', 'postalCode', 'nationalityId',
    'passportNumber', 'studentLocationPreferences', 'studentSchoolPreferences', 'studentCoursePreferences', 'startDay', 'startMonth', 'startYear',
    'durationWeekAmount', 'accommodation', 'hoursPerWeek', 'amOrPm', 'budget', 'notes'
  );

  for ($i = 0; $i < count($fieldArr); $i++) {
    $valid[$fieldArr[$i]]['checkbox'] = (isset($input[$num][$fieldArr[$i].'_checkbox']) && !empty($input[$num][$fieldArr[$i].'_checkbox'])) ? 1 : 0;

    if(!empty($input[$num][$fieldArr[$i].'_required'])){
      $valid[$fieldArr[$i]]['required'] = 1;
    } else {
      $valid[$fieldArr[$i]]['required'] = 0;
    };

    if(!empty($input[$num][$fieldArr[$i].'_label'])){
      $valid[$fieldArr[$i]]['label'] = sanitize_text_field($input[$num][$fieldArr[$i].'_label']);
    } else {
      if(isset($options[$num][$fieldArr[$i]]['label'])) {
        $valid[$fieldArr[$i]]['label'] = $options[$num][$fieldArr[$i]]['label'];
      } else {
        $valid[$fieldArr[$i]]['label'] = $valid[$fieldArr[$i]]['name'];
      };
    };

    $valid[$fieldArr[$i]]['order'] = (isset($input[$num][$fieldArr[$i].'_order']) && !empty($input[$num][$fieldArr[$i].'_order']) && is_numeric($input[$num][$fieldArr[$i].'_order'])) ? sanitize_text_field($input[$num][$fieldArr[$i].'_order']) : 0;
  };

  // require firstname always
  $valid['firstname']['required'] = 1;
  $valid['firstname']['checkbox'] = 1;
  
  $predefinedDropdownArr = array('durationWeekAmount', 'startMonth', 'startYear');

  for ($i = 0; $i < count($predefinedDropdownArr); $i++) {
    if(!empty($input[$num][$predefinedDropdownArr[$i].'_type'])){
      $valid[$predefinedDropdownArr[$i]]['type'] = $input[$num][$predefinedDropdownArr[$i].'_type'];
    } else {
      if(isset($options[$num][$predefinedDropdownArr[$i]]['type'])) {
        $valid[$predefinedDropdownArr[$i]]['type'] = $options[$num][$predefinedDropdownArr[$i]]['type'];
      } else {
        $valid[$predefinedDropdownArr[$i]]['type'] = 'Default';
      }
    };

    if(!empty($input[$num][$predefinedDropdownArr[$i].'_options'])){
      $valid[$predefinedDropdownArr[$i]]['options'] = $input[$num][$predefinedDropdownArr[$i].'_options'];
    } else {
      if(isset($options[$num][$predefinedDropdownArr[$i]]['options'])) {
        $valid[$predefinedDropdownArr[$i]]['options'] = $options[$num][$predefinedDropdownArr[$i]]['options'];
      } else {
        $valid[$predefinedDropdownArr[$i]]['options'] = "";
      };
    };
  }


  /* Gender */
  $valid['gender']['option']['M'] = (isset($input[$num]['M']) && !empty($input[$num]['M'])) ? sanitize_text_field($input[$num]['M']) : 'Male';
  $valid['gender']['option']['F'] = (isset($input[$num]['F']) && !empty($input[$num]['F'])) ? sanitize_text_field($input[$num]['F']) : 'Female';

  /* City, Provice/Region */
  if(!empty($input[$num]['currentLocationGooglePlaceId_type'])){
    $valid['currentLocationGooglePlaceId']['type'] = sanitize_text_field($input[$num]['currentLocationGooglePlaceId_type']);
  } else {
    if(isset($options[$num]['currentLocationGooglePlaceId']['type'])) {
      $valid['currentLocationGooglePlaceId']['type'] = $options[$num]['currentLocationGooglePlaceId']['type'];
    } else {
      $valid['currentLocationGooglePlaceId']['type'] = '';
    }
  };

  if(!empty($input[$num]['currentLocationGooglePlaceId_options'])){
    $valid['currentLocationGooglePlaceId']['options'] = $input[$num]['currentLocationGooglePlaceId_options'];
  } else {
    if(isset($options[$num]['currentLocationGooglePlaceId']['options'])) {
      $valid['currentLocationGooglePlaceId']['options'] = $options[$num]['currentLocationGooglePlaceId']['options'];
    } else {
      $valid['currentLocationGooglePlaceId']['options'] = "";
    };
  };

  if(!empty($input[$num]['currentLocationGooglePlaceId_ids'])){
    $valid['currentLocationGooglePlaceId']['ids'] = $input[$num]['currentLocationGooglePlaceId_ids'];
  } else {
    if(isset($options[$num]['currentLocationGooglePlaceId']['ids'])) {
      $valid['currentLocationGooglePlaceId']['ids'] = $options[$num]['currentLocationGooglePlaceId']['ids'];
    } else {
      $valid['currentLocationGooglePlaceId']['ids'] = "";
    };
  };

  /* Nationality */
  $valid['nationalityId']['lang'] = (isset($input[$num]['nationalityId_lang']) && !empty($input[$num]['nationalityId_lang'])) ? sanitize_text_field($input[$num]['nationalityId_lang']) : '';

  /* Destinations */
  if(!empty($input[$num]['studentLocationPreferences_type'])){
    $valid['studentLocationPreferences']['type'] = sanitize_text_field($input[$num]['studentLocationPreferences_type']);
  } else {
    if(isset($options[$num]['studentLocationPreferences']['type'])) {
      $valid['studentLocationPreferences']['type'] = $options[$num]['studentLocationPreferences']['type'];
    } else {
      $valid['studentLocationPreferences']['type'] = '';
    }
  };

  if(!empty($input[$num]['studentLocationPreferences_options'])){
    $valid['studentLocationPreferences']['options'] = $input[$num]['studentLocationPreferences_options'];
  } else {
    if(isset($options[$num]['studentLocationPreferences']['options'])) {
      $valid['studentLocationPreferences']['options'] = $options[$num]['studentLocationPreferences']['options'];
    } else {
      $valid['studentLocationPreferences']['options'] = "";
    };
  };

  if(!empty($input[$num]['studentLocationPreferences_ids'])){
    $valid['studentLocationPreferences']['ids'] = $input[$num]['studentLocationPreferences_ids'];
  } else {
    if(isset($options[$num]['studentLocationPreferences']['ids'])) {
      $valid['studentLocationPreferences']['ids'] = $options[$num]['studentLocationPreferences']['ids'];
    } else {
      $valid['studentLocationPreferences']['ids'] = "";
    };
  };

  /* Schools */
  if(!empty($input[$num]['studentSchoolPreferences_type'])){
    $valid['studentSchoolPreferences']['type'] = sanitize_text_field($input[$num]['studentSchoolPreferences_type']);
  } else {
    if(isset($options[$num]['studentSchoolPreferences']['type'])) {
      $valid['studentSchoolPreferences']['type'] = $options[$num]['studentSchoolPreferences']['type'];
    } else {
      $valid['studentSchoolPreferences']['type'] = '';
    }
    
  };

  if(!empty($input[$num]['studentSchoolPreferences_options'])){
    $valid['studentSchoolPreferences']['options'] = $input[$num]['studentSchoolPreferences_options'];
  } else {
    if(isset($options[$num]['studentSchoolPreferences']['options'])) {
      $valid['studentSchoolPreferences']['options'] = $options[$num]['studentSchoolPreferences']['options'];
    } else {
      $valid['studentSchoolPreferences']['options'] = "";
    };
  };

  /* Courses */
  if(!empty($input[$num]['studentCoursePreferences_type'])){
    $valid['studentCoursePreferences']['type'] = sanitize_text_field($input[$num]['studentCoursePreferences_type']);
  } else {
    if(isset($options[$num]['studentCoursePreferences']['type'])) {
      $valid['studentCoursePreferences']['type'] = $options[$num]['studentCoursePreferences']['type'];
    } else {
      $valid['studentCoursePreferences']['type'] = '';
    }
  };

  if(!empty($input[$num]['studentCoursePreferences_options'])){
    $valid['studentCoursePreferences']['options'] = $input[$num]['studentCoursePreferences_options'];
  } else {
    if(isset($options[$num]['studentCoursePreferences']['options'])) {
      $valid['studentCoursePreferences']['options'] = $options[$num]['studentCoursePreferences']['options'];
    } else {
      $valid['studentCoursePreferences']['options'] = "";
    };
  };
  
  /* AM or PM */
  $valid['amOrPm']['option']['am'] = (isset($input[$num]['amOrPm_option_am']) && !empty($input[$num]['amOrPm_option_am'])) ? sanitize_text_field($input[$num]['amOrPm_option_am']) : 'AM';
  $valid['amOrPm']['option']['pm'] = (isset($input[$num]['amOrPm_option_pm']) && !empty($input[$num]['amOrPm_option_pm'])) ? sanitize_text_field($input[$num]['amOrPm_option_pm']) : 'PM';
  
  /* Custom Fields */
  if(!empty($input[$num]['customPropertyValues'])) {

    foreach($input[$num]['customPropertyValues'] as $item => $unit ){

      if(!empty($input[$num]['customPropertyValues'][$item]['type'])){
        $type = $input[$num]['customPropertyValues'][$item]['type'];
      } else {
        if(isset($options[$num]['customPropertyValues'][$item]['type'])) {
          $type = $options[$num]['customPropertyValues'][$item]['type'];
        } else {
          $type = "Text";
        };
      };

      if(!empty($input[$num]['customPropertyValues'][$item]['label'])){
        $label = sanitize_text_field($input[$num]['customPropertyValues'][$item]['label']);
      } else {
        if(isset($options[$num]['customPropertyValues'][$item]['label'])) {
          $label = $options[$num]['customPropertyValues'][$item]['label'];
        } else {
          $label = "";
        };
      };

      if(!empty($input[$num]['customPropertyValues'][$item]['id'])){
        $id = sanitize_text_field($input[$num]['customPropertyValues'][$item]['id']);
      } else {
        if(isset($options[$num]['customPropertyValues'][$item]['id'])) {
          $id = $options[$num]['customPropertyValues'][$item]['id'];
        } else {
          $id = "";
        };
      };

      if(!empty($input[$num]['customPropertyValues'][$item]['required'])){
        $required = 1;
      } else {
        $required = 0;
      };

      if(!empty($input[$num]['customPropertyValues'][$item]['options'])){
        $opt = $input[$num]['customPropertyValues'][$item]['options'];
      } else {
        if(isset($options[$num]['customPropertyValues'][$item]['options'])) {
          $opt = $options[$num]['customPropertyValues'][$item]['options'];
        } else {
          $opt = "";
        };
      };

      if(!empty($input[$num]['customPropertyValues'][$item]['order'])){
        $order = sanitize_text_field($input[$num]['customPropertyValues'][$item]['order']);
      } else {
        if(isset($options[$num]['customPropertyValues'][$item]['order'])) {
          $order = $options[$num]['customPropertyValues'][$item]['order'];
        } else {
          $order = 0;
        };
      };

      $valid['customPropertyValues'][$item] = array('type'=>$type, 'label'=>$label, 'id'=>$id, 'required'=>$required, 'options'=>$opt, 'order'=>$order);

    }
  } else {
    $valid['customPropertyValues'] = '';
  }

  /* Settings */
  $valid['submit'] = (isset($input[$num]['submit']) && !empty($input[$num]['submit'])) ? sanitize_text_field($input[$num]['submit']) : '';
  $valid['valid_required'] = (isset($input[$num]['valid_required']) && !empty($input[$num]['valid_required'])) ? sanitize_text_field($input[$num]['valid_required']) : 'This field is required';
  $valid['valid_email'] = (isset($input[$num]['valid_email']) && !empty($input[$num]['valid_email'])) ? sanitize_text_field($input[$num]['valid_email']) : 'This email is invalid';
  $valid['success_radio'] = (isset($input[$num]['success_radio']) && !empty($input[$num]['success_radio'])) ? sanitize_text_field($input[$num]['success_radio']) : '';
  $valid['success_message'] = (isset($input[$num]['success_message']) && !empty($input[$num]['success_message'])) ? sanitize_text_field($input[$num]['success_message']) : 'message';
  $valid['success_url'] = (isset($input[$num]['success_url']) && !empty($input[$num]['success_url'])) ? sanitize_text_field($input[$num]['success_url']) : 'http://';
  $valid['fail_message'] = (isset($input[$num]['fail_message']) && !empty($input[$num]['fail_message'])) ? sanitize_text_field($input[$num]['fail_message']) : 'message';

  /* css block */
  $valid['css'] = (isset($input[$num]['css']) && !empty($input[$num]['css'])) ? $input[$num]['css'] : '';

  /* javascript block */
  $valid['js'] = (isset($input[$num]['js']) && !empty($input[$num]['js'])) ? $input[$num]['js'] : '';
  $valid['jspost'] = (isset($input[$num]['jspost']) && !empty($input[$num]['jspost'])) ? $input[$num]['jspost'] : '';

  return $valid;
};