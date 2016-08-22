<?php



class User extends Model {
	protected $table = 'users';
	protected $fillable = [
		'id',
		'username',
		'email',
		'permissions',
		'last_name',
		'first_name',
		'middle_name',
		'sex',
		'birthdate',
		'bloodtype',
		'password',
		'is_deleted'
	];
	protected $hidden = [
		'password',
		'created_at', 
		'updated_at', 
		'is_deleted', 
		'activation_code', 
		'activated_at',
		'last_login',
		'persist_code',
		'reset_password_code'
	];

	protected $appends = ['full_name'];

	public function studentInfo(){

		/** K: Please understand that you must not read the following as "This
		* [user] has many Student", instead, read it as "This [user]
		* has or had many instances of being a student." For example,
		* K has been a BSTRM student in the 1st semester of A.Y. 
		* 2011-2012; he shifted to BSIT the next semester. In each
		* instance of being a student, the registrar assigns a number.
		* When K was a BSTRM pupil, his number was "201101047", for the latter
		* is "201102041"
		*
		* However, the courses TOR and Certificate of Grades to be generated
		* is per the the curriculum of the student's chosen degree. There are courses
		* that belong in BSIT that is also found in other degrees' curricula, such as ENG1.
		* K has enrolled ENG1 in a session held by a section of BSTRM students
		* while he was a BSTRM student. K acquired the grade and it'll be included in his TOR
		* of his BSIT Degree despite being the subject being taken in his past 
		* (BSTRM) student identity.
		*/
		return $this->hasMany('\\Student');
	}

	public function employeeInfo(){

		/** K: A user can also be an employee under the right circumstances.
		* an employee can be an instructor of a course. A user can also be an alumni/alumna
		* which means that there is an information of him/her being a student
		* of the past; he/she might be an employee now, teaching or not. Student assistants also exist,
		* they receive free tuition by rendering service in the school of 200 hours
		*/
		return $this->hasOne('\\Employee');
	}

	public function getFullNameAttribute () {
		$middle_initial = $this->middle_name ? substr($this->middle_name, 0, 1) . '. '  : '';
		return $this->first_name . ' ' . $middle_initial . $this->last_name;
	}

	public function setUsernameAttribute($value){
		$uname = trim($value);
		if ($uname == '' || $uname == null){
                $this->attributes['username'] = uniqid();
            } else {
                $this->attributes['username'] = $uname;
            }
        $this->save();
	}

	public function setPasswordAttribute($value){
		if($value != '' || $value != null){
			$user = Sentry::findUserById($this->id);
			$user->username = $this->username;
			$user->password = $value;
			$user->save();
		}
	}

	

}