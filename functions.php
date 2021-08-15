<?php
function getVartotojas(): array
{
    if (!file_exists(__DIR__ . '/vartotojai.json')) {
        $vartotojai = [];
        $vartotojai = json_encode($vartotojai);
        file_put_contents(__DIR__ . '/vartotojai.json', $vartotojai);
    }
    return json_decode(file_get_contents(__DIR__ . '/vartotojai.json'), 1);
}

function setVartotojas(array $vartotojai): void
{
    $vartotojai = json_encode($vartotojai);
    file_put_contents(__DIR__ . '/vartotojai.json', $vartotojai);
}

function router()
{
    $route = $_GET['route'] ?? '';

    if ('POST' == $_SERVER['REQUEST_METHOD'] && 'prideti-lesas2' == $route) {
        pridetiLesas2();
    } elseif ('POST' == $_SERVER['REQUEST_METHOD'] && 'atimti-lesas2' == $route) {
        atimtiLesas2();
    } elseif ('POST' == $_SERVER['REQUEST_METHOD'] && 'prideti-lesas' == $route) {
        pridetiLesas();
    } elseif ('POST' == $_SERVER['REQUEST_METHOD'] && 'atimti-lesas' == $route) {
        atimtiLesas();
    } elseif ('POST' == $_SERVER['REQUEST_METHOD'] && 'pasalinti-sas' == $route) {
        pasalintiSas();
    } elseif ('POST' == $_SERVER['REQUEST_METHOD'] && 'prideti-sas' == $route) {
        pridetiSas();
    }
}

//--------------------------------------- PRINT --------------------------------------------

function printSas()
{
    $for = 1;
    foreach (thisUserArray()['IBAN'] as $key => $array) {
        echo
        '<tr class="text-center">
        <th scope="row">' . $for . '</th>
          <td>' . $key . '</td>
          <td scope="row" class="text-center">
          <span class="moneytext-accountlist mx-5"> ' . round($array, 2) . ' EUR' . '</span>
          <td class="text-center">
        <div class="btndiv-accountlist">
            <form action="https://localhost/Projektas/Bankas/fundcontrol.php" method="post">
            <button type="submit" name="a" value=' . $for . ' class="btn btn-secondary btn-sm mx-1">Tvarkyti sąskaitą</button>
            </form>
            <form action="https://localhost/Projektas/Bankas/accountlist.php?route=pasalinti-sas" method="post">
            <button type="submit" name="b" value=' . $for . ' class="btn btn-danger btn-sm mx-4">Pašalinti sąskaitą</button>
            </form>
        </div>
        </td>
    </td>
    </tr>';
        $for++;
    }
}

function selectingSas()
{
    if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_SESSION['id'])) {
        if (!empty($_POST['a'])) {
            $_SESSION['IBANID'] =  array();
            $_SESSION['IBANID'] = $_POST['a'];
            header('Location:https://localhost/Projektas/Bankas/fundcontrol.php');
            die;
            return $_SESSION['IBANID'] = $_SESSION['IBANID'];
        } else if (!empty($_POST['b'])) {
            $_SESSION['IBANID'] =  array();
            $_SESSION['IBANID'] = $_POST['b'];
            return $_SESSION['IBANID'] = $_SESSION['IBANID'];
        }
    }
}

function showingallSas()
{
    $vartotojai = getVartotojas();
    $for = 1;
    foreach ($vartotojai as $array) {
        foreach ($array as $main => $value) {
            if (gettype($value) == 'array') {
                foreach ($value as $sasnr => $money) {
                    echo
                    '<tr class="text-center">
              <th scope="row">' . $for . '</th>
              <td class="td-allaccountlist">' . $sasnr . '</td>
              <td class="td-allaccountlist">' . $array['Vardas'] . '</td>
              <td class="td-allaccountlist">' . $array['Pavarde'] . '</td>
              <td class="text-center">' . round($money, 2) . '</td>
              <td class="text-center">
                    <div class="btndiv-allaccountlist">
                        <form action="https://localhost/Projektas/Bankas/allaccountlist.php?route=prideti-lesas2" method="post">
                        <input  name = "les_plus" class="input-allaccountlist">
                        <button type="submit" name="c" value=' . $sasnr . '  class="btn btn-primary btn-sm mx-1 mb-1">Pridėti lėšų</button>
                        </form>
                        <form action="https://localhost/Projektas/Bankas/allaccountlist.php?route=atimti-lesas2" method="post">
                        <input name = "les_minus" class="input-allaccountlist">
                        <button type="submit" name="c" value=' . $sasnr . '  class="btn btn-secondary btn-sm mx-1 mb-1">Atimti lėšas</button>
                        </form>
                        <form action="https://localhost/Projektas/Bankas/accountlist.php?route=pasalinti-sas" method="post">
                        <button type="submit" name="b" value=' . $sasnr . ' class="btn btn-danger btn-sm mx-4">Pašalinti sąskaitą</button>
                        </form>
                    </div>
                </td>
            </tr>';
                    $for++;
                }
            }
        }
    }
}

//--------------------------------------- GETTERIAI --------------------------------------------

function thisUserArray()
{
    $vartotojai = getVartotojas();
    foreach ($vartotojai as $array) {
        if ($array['ID'] == $_SESSION['id']) {
            $thisuser = $array;
        }
    }
    return $thisuser;
}


function thisUserSasNR()
{
    $times = 1;
    foreach (thisUserArray()['IBAN'] as $key => $array) {
        if ($times == $_SESSION['IBANID']) {
            $sasnrarray = $key;
        }
        $times++;
    }
    return $sasnrarray;
}

function thisUserMoney()
{
    $times = 1;
    foreach (thisUserArray()['IBAN'] as $array) {
        if ($times == $_SESSION['IBANID']) {
            $moneyarr = $array;
        }
        $times++;
    }
    return $moneyarr;
}
//--------------------------------------- PRIDETI/ATIMTI LĖŠAS --------------------------------------------

function pridetiLesas()
{
    if (!is_numeric($_POST['les_plus']) || $_POST['les_plus'] < 0) {
        addMessage('danger', 'Blogai įrašyta informacija');
        header('Location:https://localhost/Projektas/Bankas/fundcontrol.php');
        die;
    }
    if (is_numeric($_POST['les_plus'])) {
        $_POST['les_plus'] =  round($_POST['les_plus'], 2);
    }
    $times = 1;
    $vartotojai = getVartotojas();
    foreach ($vartotojai as &$array) {
        if ($array['ID'] == $_SESSION['id']) {
            foreach ($array['IBAN'] as &$value) {
                if ($_SESSION['IBANID'] == $times) {
                    $value += $_POST['les_plus'];
                }
                $times++;
            }
        }
    }
    setVartotojas($vartotojai);
    addMessage('success', 'Lėšos sėkmingai pridėtos');
    header('Location:https://localhost/Projektas/Bankas/fundcontrol.php');
    die;
}

function pridetiLesas2()
{
    if (!is_numeric($_POST['les_plus']) || $_POST['les_plus'] < 0) {
        addMessage('danger', 'Blogai įrašyta informacija');
        header('Location:https://localhost/Projektas/Bankas/allaccountlist.php');
        die;
    }
    if (is_numeric($_POST['les_plus'])) {
        $_POST['les_plus'] = round($_POST['les_plus'], 2);
    }
    $vartotojai = getVartotojas();
    foreach ($vartotojai as &$array) {
        foreach ($array['IBAN'] as $key => &$value) {
            if ($_POST['c'] == $key) {
                $value += $_POST['les_plus'];
            }
        }
    }
    setVartotojas($vartotojai);
    addMessage('success', 'Lėšos sėkmingai pridėtos');
    header('Location:https://localhost/Projektas/Bankas/allaccountlist.php');
    die;
}

function atimtiLesas()
{
    if (!is_numeric($_POST['les_minus']) || $_POST['les_minus'] < 0) {
        addMessage('danger', 'Blogai įrašyta informacija');
        header('Location:https://localhost/Projektas/Bankas/fundcontrol.php');
        die;
    }
    if (is_numeric($_POST['les_minus'])) {
        $_POST['les_minus'] = round($_POST['les_minus'], 2);
    }
    $times = 1;
    $vartotojai = getVartotojas();
    foreach ($vartotojai as &$array) {
        if ($array['ID'] == $_SESSION['id']) {
            foreach ($array['IBAN'] as &$value) {
                if ($_SESSION['IBANID'] == $times) {
                    if ($_POST['les_minus'] > $value) {
                        addMessage('danger', 'Neužtenka lėšų');
                    } else if ($_POST['les_minus'] <= $value) {
                        $value -= $_POST['les_minus'];
                        addMessage('success', 'Lėšos sėkmingai atimtos');
                    }
                    $times++;
                }
            }
        }
    }
    setVartotojas($vartotojai);
    header('Location:https://localhost/Projektas/Bankas/fundcontrol.php');
    die;
}

function atimtiLesas2()
{
    if (!is_numeric($_POST['les_minus']) || $_POST['les_minus'] < 0) {
        addMessage('danger', 'Blogai įrašyta informacija');
        header('Location:https://localhost/Projektas/Bankas/allaccountlist.php');
        die;
    }
    if (is_numeric($_POST['les_minus'])) {
        $_POST['les_minus'] = round($_POST['les_minus'], 2);
    }
    $vartotojai = getVartotojas();
    foreach ($vartotojai as &$array) {
        foreach ($array['IBAN'] as $key => &$value) {
            if ($_POST['c'] == $key) {
                if ($_POST['les_minus'] > $value) {
                    addMessage('danger', 'Neužtenka lėšų');
                } else if ($_POST['les_minus'] <= $value) {
                    $value -= $_POST['les_minus'];
                    addMessage('success', 'Lėšos sėkmingai atimtos');
                }
            }
        }
    }
    setVartotojas($vartotojai);
    header('Location:https://localhost/Projektas/Bankas/allaccountlist.php');
    die;
}

function pridetiSas()
{
    $vartotojai = getVartotojas();
    foreach ($vartotojai as &$array) {
        if ($array['ID'] == $_SESSION['id']) {
            $array['IBAN'] += [createIBAN() => 0];
        }
    }
    setVartotojas($vartotojai);
    addMessage('success', 'Nauja sąskaita sėkmingai sukurta');
    header('Location:https://localhost/Projektas/Bankas/accountlist.php');
    die;
}

function pasalintiSas()
{
    $times = 1;
    $vartotojai = getVartotojas();
    foreach ($vartotojai as &$array) {
        if ($array['ID'] == $_SESSION['id'] || $_SESSION['id'] == 1) {
            foreach ($array['IBAN'] as $key => &$value) {
                if ($_SESSION['IBANID'] == $key) {
                    unset($array['IBAN'][$_SESSION['IBANID']]);
                    addMessage('success', 'Sėkmingai pašalinta sąskaita');
                } else if ($_SESSION['IBANID'] == $times && $value == 0) {
                    unset($array['IBAN'][$key]);
                    addMessage('success', 'Sėkmingai pašalinta sąskaita');
                } else if ($_SESSION['IBANID'] == $times && $value > 0) {
                    addMessage('danger', 'Sąskaitoje yra lėšų');
                }
                $times++;
            }
        }
    }
    setVartotojas($vartotojai);
    if ($_SESSION['id'] == 1) {
        header('Location:https://localhost/Projektas/Bankas/allaccountlist.php');
        die;
    }
    header('Location:https://localhost/Projektas/Bankas/accountlist.php');
    die;
}

//--------------------------------------- ŽINUTĖS --------------------------------------------
// type succes|danger

function addMessage(string $type, string $msg): void
{
    $_SESSION['msg'][] = ['type' => $type, 'msg' => $msg];
}

function clearMessages(): void
{
    $_SESSION['msg'] = [];
}

function showMessages(): void
{
    $messages = $_SESSION['msg'];
    clearMessages();
    require __DIR__ . '/msg.php';
}

//--------------------------------------- AUTORIZACIJA --------------------------------------------

function logout()
{
    session_start();
    unset($_SESSION['id']);
    unset($_SESSION['IBANID']);
    unset($_SESSION['name']);
    addMessage('success', 'Sėkmingai atsijungta');
    header('Location:https://localhost/Projektas/Bankas/index.php');
    die;
}

function isLogged()
{
    if (isset($_SESSION['id']) && $_SESSION['id'] > 1) {
        return true;
    }
}

function workerisLogged()
{
    if (isset($_SESSION['id']) && $_SESSION['id'] == 1) {
        return true;
    }
}

function auth()
{
    if (!isset($_SESSION['id'])) {
        header('Location:https://localhost/Projektas/Bankas/index.php');
        die;
    }
}

function validateSessionID()
{
    if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['ASMK'])) {
        $vartotojai = getVartotojas();
        foreach ($vartotojai as $masindex => $array) {
            if ($_POST['ASMK'] == $array['ASMK'] && $_POST['Vardas'] == $array['Vardas'] && $_POST['Pavarde'] == $array['Pavarde']) {
                $_SESSION['id'] = $array['ID'];
                addMessage('success', 'Sėkmingai prisijungta');
            }
        }
        if (!isset($_SESSION['id'])) {
            addMessage('danger', 'Blogai suvesta informacija');
        }
        header('Location:https://localhost/Projektas/Bankas/newuser.php');
        die;
        return $_SESSION['id'] = $_SESSION['id'];
    }
    if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['pass'])) {
        $darbuotojai = getDarbuotojas();
        foreach ($darbuotojai as $masindex => $array) {
            if ($_POST['Vardas'] == $array['Vardas'] && $_POST['Epastas'] == $array['Epastas'] && md5($_POST['pass']) == $array['pass']) {
                $_SESSION['id'] = $array['ID'];
                $_SESSION['name'] = $array['Vardas'];
                addMessage('success', 'Sėkmingai prisijungta');
            }
        }
        if (!isset($_SESSION['id'])) {
            addMessage('danger', 'Blogai suvesta informacija');
        }
        header('Location:https://localhost/Projektas/Bankas/workerlogin.php');
        die;
        return $_SESSION['id'] = $_SESSION['id'];
    }
}

function validateASMK()
{
    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        $vartotojai = getVartotojas();
        if ($_POST['Vardas'] != '') {
            foreach ($vartotojai as $masindex => $masyvas) {
                if ($masyvas['ASMK'] == $_POST['ASMK']) {
                    addMessage('danger', 'Blogai įvesta informacija');
                    header('Location: https://localhost/Projektas/Bankas/newuser.php');
                    die;
                }
            }
        }
    }
}

//--------------------------------------- DARBUOTUOJAI --------------------------------------------

function getDarbuotojas(): array
{
    if (!file_exists(__DIR__ . '/darbuotojai.json')) {
        $darbuotojai = [
            ['Vardas' => 'Ernestas', 'Epastas' => 'ernestas@gmail.com', 'pass' => md5('12345'), 'ID' => 1],
            ['Vardas' => 'Petras', 'Epastas' => 'petras@gmail.com', 'pass' => md5('12345'), 'ID' => 1],
            ['Vardas' => 'Admin', 'Epastas' => 'admin@gmail.com', 'pass' => md5('12345'), 'ID' => 1]
        ];
        $darbuotojai = json_encode($darbuotojai);
        file_put_contents(__DIR__ . '/darbuotojai.json', $darbuotojai);
    }
    return json_decode(file_get_contents(__DIR__ . '/darbuotojai.json'), 1);
}

function workerName()
{
    $darbuotojai = getDarbuotojas();
    foreach ($darbuotojai as $array) {
        if ($array['ID'] == $_SESSION['id']) {
            $thisuser = $array;
        }
    }
    return $thisuser;
}

//--------------------------------------- MISC --------------------------------------------

function createIBAN()
{
    $IBAN = "LT01" . rand(0, 99) . rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999);
    return $IBAN;
}

function createID()
{
    $ID = rand(1000000000, 9999999999);
    return $ID;
}

function createNewUser()
{
    if ('POST' == $_SERVER['REQUEST_METHOD']) {
        $vartotojai = getVartotojas();
        if (mb_strlen($_POST['Vardas'], "UTF-8") < 3 || mb_strlen($_POST['Pavarde'], "UTF-8") < 3 ||  (mb_strlen($_POST['ASMK'], "UTF-8") < 11 || mb_strlen($_POST['ASMK'], "UTF-8") > 11)) {
            addMessage('danger', 'Blogai įvesta informacija');
            header('Location:https://localhost/Projektas/Bankas/newuser.php');
            die;
        } else {
            $vartotojai[] = ['Vardas' => $_POST['Vardas'], 'Pavarde' => $_POST['Pavarde'], 'IBAN' => [$_POST['SasNR'] => 0], 'ASMK' => $_POST['ASMK'], 'ID' => createID()];
            setVartotojas($vartotojai);
            addMessage('success', 'Vartotojas sėkmingai sukurtas');
            header('Location:https://localhost/Projektas/Bankas/newuser.php');
            die;
        }
    }
}
