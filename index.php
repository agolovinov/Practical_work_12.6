<?php

$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'Aль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

$fullnameData = $example_persons_array[array_rand($example_persons_array, 1)]['fullname'];
echo '<pre>';
echo ($fullnameData) . ' - Первоначальный вывод ФИО для проверки.';
echo '</pre>';

function getPartsFromFullname($fullnameData)
{
    $explodedFullname = explode(" ", $fullnameData);
    $fullnameForm = ['name', 'surname', 'patronomyc'];
    $fullnameArray = array_combine($fullnameForm,$explodedFullname);
    return $fullnameArray;  
};
$fullnameArray = getPartsFromFullname($fullnameData);
echo '<pre>';
echo 'Результат функции getPartsFromFullname:<br>';
print_r($fullnameArray);
echo '</pre>';

// Задаю аргументы для функции getFullnameFromParts.
$name = $fullnameArray['name'];
$surname = $fullnameArray['surname'];
$patronomyc = $fullnameArray['patronomyc'];

function getFullnameFromParts($name, $surname, $patronomyc)
{
    $newFullname = [$name, $surname, $patronomyc];
    $implodedFullname = implode(" ", $newFullname);
    return $implodedFullname;
};
$assembledFullname = getFullnameFromParts($name, $surname, $patronomyc);
echo '<pre>';
echo $assembledFullname . ' - Результат функции getFullnameFromParts.';
echo '</pre>';

function getShortName($fullnameData)
{
	$fullnameArray = getPartsFromFullname($fullnameData);
	$firstName = $fullnameArray['surname'];
	$nameInitial = mb_substr($fullnameArray['name'], 0, 1) . '.';
	$shortName = ($firstName . ' ' . $nameInitial);
    return $shortName;
};	
$shortenedName = getShortName($fullnameData);
echo '<pre>';
echo $shortenedName . ' - Результат функции getShortName.';
echo '</pre>';

function getGenderFromName($fullnameData)
{
	$fullnameArray = getPartsFromFullname($fullnameData);
    $sumOfSexSigns = 0;
	$nameSign = mb_substr($fullnameArray['name'], -1, 1);
	
	$sumOfSexSigns = ($nameSign === 'а' || $nameSign === 'я' )? $sumOfSexSigns -= 1 : $sumOfSexSigns += 0;
	$sumOfSexSigns = ($nameSign === 'в' || $nameSign === 'н' )? $sumOfSexSigns += 1 : $sumOfSexSigns += 0;

	$surnameSign = mb_substr($fullnameArray['surname'], -1, 1);

	$sumOfSexSigns = ($surnameSign === 'а' || $surnameSign === 'я' || $surnameSign === 'ь' ) ? $sumOfSexSigns -= 1 : $sumOfSexSigns += 0;
	$sumOfSexSigns = ($surnameSign === 'р' || $surnameSign === 'й' || $surnameSign === 'н' || $surnameSign === 'д' ) ? $sumOfSexSigns += 1 : $sumOfSexSigns += 0; 

	$patronomycSign = mb_substr($fullnameArray['patronomyc'], -3, 3);
    
	$sumOfSexSigns = ($patronomycSign === 'вна' ) ? $sumOfSexSigns -= 1 : $sumOfSexSigns += 0;
	$sumOfSexSigns = ($patronomycSign === 'вич' ) ? $sumOfSexSigns += 1 : $sumOfSexSigns += 0;  

	$sexOfPerson = ($sumOfSexSigns <=> 0);
	if ($sexOfPerson === 1) {
    $gender = 'Пол мужской';
    } else if ($sexOfPerson === -1) {
	$gender = 'Пол женский';
    } else {
	$gender = 'Пол неопределён';
    }
	return $gender;
};
$genderOfPerson = getGenderFromName($fullnameData);
echo '<pre>';
echo ($genderOfPerson) . ' - Результат функции getGenderFromName.';
echo '</pre>';

function getGenderDescription($example_persons_array)
{
	$male = 0;
	$female = 0;
	$indeterminate = 0;
	foreach($example_persons_array as $element) 
	{
		$fullnameData = $element['fullname'];
		$gender = getGenderFromName($fullnameData);
		if ($gender === 'Пол мужской') {
			$male++;
		} else if($gender === 'Пол женский') {
		    $female++;
		} else {
			$indeterminate++;
		}
	}
    $sexValues = [$male, $female, $indeterminate];
    $numberOfPersons = (count($example_persons_array));
    $personPart = 100 / $numberOfPersons;
    $males = (round($personPart * $sexValues['0'], 2));
    $females = (round($personPart * $sexValues['1'], 2));
    $indeterminates = (round($personPart * $sexValues['2'], 2));
    $genderValues = [$males, $females, $indeterminates];
	return $genderValues;
};
$valuesOfGender = getGenderDescription($example_persons_array);

echo '<pre>';
echo 'Гендерный состав аудитории<br>';
echo '----------------------<br>';
echo 'Мужчины - ' . $valuesOfGender[0] . '%<br>';
echo 'Женщины - ' . $valuesOfGender[1] . '%<br>';
echo 'Не удалось определить - ' . $valuesOfGender[2];
echo '</pre>';

function getPerfectPartner($name, $surname, $patronomyc, $example_persons_array)
{
	$newName = mb_convert_case($name, MB_CASE_TITLE_SIMPLE);
	$newSurname = mb_convert_case($surname, MB_CASE_TITLE_SIMPLE);
	$newPatronomyc = mb_convert_case($patronomyc, MB_CASE_TITLE_SIMPLE);
	$newFullnameData = getFullnameFromParts($newName, $newSurname, $newPatronomyc);
	$personGender = getGenderFromName($newFullnameData);
	$partner = $example_persons_array[array_rand($example_persons_array, 1)]['fullname'];
    echo '<pre>';
	echo $partner . ' - ФИО потенциального претендента (для контроля)';
    echo '</pre>';
	$partnerGender = getGenderFromName($partner);
	if (($personGender === $partnerGender) || ($partnerGender === 'Пол неопределён')) {
		$partner = $example_persons_array[array_rand($example_persons_array, 1)]['fullname'];
        echo '<pre>Эти люди не подходят друг другу. Перезагрузите страницу.</pre>';
	} else if($personGender === 'Пол неопределён') {
		$alert = '<pre>Не удалось установить пол.<br>Смените претендента - перезагрузите страницу.</pre>';
        return print($alert) ;
	} else{
		$personShort = getShortName($newFullnameData);
		$partnerShort = getShortName($partner);
		$randNum = (rand(5000, 10000) / 100);
        echo ('<pre>Идеальная пара:<br>' . $personShort . ' + ' . $partnerShort . ' = <br>Подходят друг другу на ' . $randNum . '%');
	}
};
getPerfectPartner($name, $surname, $patronomyc, $example_persons_array);

?>