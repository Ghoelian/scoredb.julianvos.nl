<?php
class Database
{
	private $con;
	private $Config;
	private $Login;

	public function __construct()
	{
		require_once(__DIR__ . '/../config/Config.php');
		require_once(__DIR__ . '/../include/Login.php');

		$this->Config = new Config();
		$this->con = mysqli_connect($this->Config->getHost(), $this->Config->getUser(), $this->Config->getPass(), $this->Config->getName());

		if (mysqli_connect_errno()) {
			die('Could not connect to the database. Please try again later!');
		}
	}

	public function load()
	{
		$this->Login = new Login();
	}

	public function getId($username)
	{
		$this->load();
		if ($stmt = $this->con->prepare('SELECT id FROM accounts WHERE username = ?')) {
			$stmt->bind_param('s', $username);
			$stmt->execute();
			$stmt->store_result();

			if ($stmt->num_rows > 0) {
				$stmt->bind_result($id);
				$stmt->fetch();

				return $id;
			} else {
				echo '<p>Could not get user id. Please try again later!</p>';
				$this->Login->log_out();
			}
			$stmt->close();
		} else {
			echo '<p>Could not get user id. Please try again later!</p>';
			$this->Login->log_out();
		}
	}

	public function deleteToken($username)
	{
		if ($stmt = $this->con->prepare('UPDATE accounts SET token = null WHERE username = ?')) {
			if ($stmt->bind_param('s', $username)) {
				if ($stmt->execute()) {
					return true;
				} else {
					echo 'Something went wrong. Please try again later!';
					return false;
				}
			} else {
				echo 'Something went wrong. Please try again later!';
				return false;
			}
		} else {
			echo 'Something went wrong. Please try again later!';
		}
	}

	public function putToken($token, $username)
	{
		$this->load();
		if ($stmt = $this->con->prepare('UPDATE accounts SET token = ? WHERE username = ?')) {
			if ($stmt->bind_param('ss', $token, $username)) {
				if ($stmt->execute()) {
					return true;
				} else {
					echo '<p>execute() failed: ' . $stmt->error . ' in ' . __FILE__ . ':' . __LINE__ . '</p>';
					return false;
				}
			} else {
				echo '<p>bind_param() failed: ' . $stmt->error . ' in ' . __FILE__ . ':' . __LINE__ . '</p>';
				return false;
			}
		} else {
			echo '<p>Could not log in. Please try again later!</p>';
			$this->Login->log_out();
		}
	}

	public function createUser($username, $password, $email)
	{
		if ($stmt = $this->con->prepare('INSERT INTO accounts (username, email, password) VALUES (?, ?, ?)')) {
			$stmt->bind_param('sss', $username, $email, password_hash($password, PASSWORD_BCRYPT));
			$stmt->execute();

			echo '<p>New user created</p>';
		} else {
			echo '<p>Could not create user</p><br>';
		}
	}

	public function getImages($name, $sort)
	{
		$sql = "SELECT name, artist, speed, score, image, fc, charter, stars, accuracy, longest_streak, sp_phrases
                FROM accounts 
                JOIN scores 
                    on accounts.id = scores.userId 
                WHERE accounts.username = ?";

		if (isset($sort)) {
			$sql .= " ORDER BY " . $sort;
		} else {
			$sql .= " ORDER BY artist";
		}

		if ($stmt = $this->con->prepare($sql)) {
			$stmt->bind_param("s", $name);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->free_result();
			$stmt->close();
		} else {
			echo "<h2>Getting scores failed. Please try again later!</h2>";
		}

		return $result;
	}

	public function getUsers()
	{
		if ($stmt = $this->con->prepare("SELECT username FROM `accounts`")) {
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->free_result();
			$stmt->close();
		} else {
			echo "<h2>Getting users failed. Please try again later!</h2>";
		}

		return $result;
	}

	public function addScore($userId)
	{
		$target_dir = __DIR__ . '/../tmp/';
		$filename = uniqid() . '.png';
		$target_file = $target_dir . $filename;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

		$check = getimagesize($_FILES['image']['tmp_name']);

		if ($check !== false) {
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
			$result = 'This is not an image.';
		}

		if ($imageFileType !== 'png') {
			$result = 'Only png images are allowed.';
			$uploadOk = 0;
		}

		if (file_exists($target_file)) {
			$uploadOk = 0;
			$result = 'The file already exists.';
		}

		if ($_FILES['image']['size'] > 2000000) {
			$uploadOk = 0;
			$result = 'Your file is too big.';
		}

		if ($uploadOk == 1) {
			if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
				$result = 'The file has been uploaded.';
			} else {
				$result = 'There was an error uploading your file. Please try again.';
			}
		} else {
			return $result;
		}

		$fields = array('img' => $target_file);
		$filenames = array($target_file);

		$files = array();

		foreach ($filenames as $f) {
			$files[$f] = file_get_contents($f);
		}

		$url = 'https://api.julianvos.nl/scanImage';
		$curl = curl_init();
		$boundary = uniqid();
		$delimiter = '-------------' . $boundary;

		$post_data = build_data_files($boundary, $fields, $files);

		curl_setopt_array($curl, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			//CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $post_data,
			CURLOPT_HTTPHEADER => array(
				//"Authorization: Bearer $TOKEN",
				"Content-Type: multipart/form-data; boundary=" . $delimiter,
				"Content-Length: " . strlen($post_data)
			),
		));

		$response = json_decode(curl_exec($curl), true);
		// return var_dump($response);

		$name = $response['SongName'];
		$artist = $response['Artist'];
		$charter = $response['Charter'];
		$speed = $response['Speed'];
		$score = $response['Score'];
		$stars = $response['Stars'];
		$accuracy = $response['Accuracy'];
		$longest_streak = $response['Longest streak'];
		$sp_phrases = $response['SP Phrases'];
		if ($response['FC'] == 'True') {
			$fc = 1;
		} else {
			$fc = 0;
		}
		// return var_dump($response);

		$path_parts = pathinfo($_FILES["image"]["name"]);
		$imageFileType = $path_parts['extension'];

		$target_dir_new = __DIR__ . "/../images/" . $userId . '/';
		$filename_new = md5(uniqid()) . '.png';
		$target_file_new = $target_dir_new . $filename_new;

		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
		}

		if (!file_exists($target_file_new)) {
			if ($imageFileType == "png") {
				if (rename($target_file, $target_file_new)) {
					$sql = "INSERT INTO `scores`
		                (`userId`, `name`, `artist`, `speed`, `score`, `fc`, `image`, `charter`, `stars`, `accuracy`, `longest_streak`, `sp_phrases`)
		                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

					if ($stmt = $this->con->prepare($sql)) {
						$temp_image = '/images/' . $userId . '/' . $filename_new;
						$temp_fc = false;
						
						if ($fc == 'True') {
							$temp_fc = true;
						}

						if ($stmt->bind_param("issiiissssis", $userId, $name, $artist, $speed, $score, $fc, $temp_image, $charter, $stars, $accuracy, $longest_streak, $sp_phrases)) {
							if ($stmt->execute()) {
								$stmt->close();
								return false;
							} else {
								return $stmt->error;
								return "<h2>Executing statement failed. Please try again later!</h2>";
							}
						} else {
							return "<h2>Binding parameters failed. Please try again later!</h2>";
						}
					} else {
						return "<h2>Preparing connection failed. Please try again later!</h2>";
					}
				} else {
					return "<h2>Moving file failed. Please try again later!</h2>";
				}
			} else {
				return "<h2>Wrong file type.</h2>";
			}
		} else {
			return "<h2>File exists. Please try again!</h2>";
		}
	}
}

function build_data_files($boundary, $fields, $files)
{
	$data = '';
	$eol = "\r\n";

	$delimiter = '-------------' . $boundary;

	foreach ($fields as $name => $content) {
		$data .= "--" . $delimiter . $eol
			. 'Content-Disposition: form-data; name="' . $name . "\"" . $eol . $eol
			. $content . $eol;
	}

	foreach ($files as $name => $content) {
		$data .= "--" . $delimiter . $eol
			. 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $name . '"' . $eol
			//. 'Content-Type: image/png'.$eol
			. 'Content-Transfer-Encoding: binary' . $eol;

		$data .= $eol;
		$data .= $content . $eol;
	}

	$data .= "--" . $delimiter . "--" . $eol;

	return $data;
}
