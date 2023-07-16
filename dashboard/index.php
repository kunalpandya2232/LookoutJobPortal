<?php




session_start();
require "../config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
use config\dbFiles\dbFIles as db;

$reqFiles = new settings();
$reqFiles->get_required_files();
if ((isset($_SESSION['status']) && $_SESSION['status'] == 1)):
    if ((isset($_SESSION['user']) && ($_SESSION['user'] == "new" || $_SESSION['user'] = "old"))):
        if (isset($_SESSION['jobSuccess'])) {
            unset($_SESSION['jobSuccess']);
        }
        $reqFiles->get_valid_checker();
        $dbconn  = new db();
        $conn    = $dbconn->getConn();
        $checker = new validChecker();
        if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
            $userDetailBASIC = $checker->getUserByEmail($conn, $_SESSION['email']);
            if (is_array($userDetailBASIC)) {
                foreach ($userDetailBASIC as $name => $value) {
                    $_SESSION[$name] = $value;
                }
            }
            $userDetail = $checker->getUserByEmailALL($conn, $_SESSION['email']);
        }
        if ($userDetail) {
            $pageName            = $userDetail['fname'] . "'s Dashborad" . SITE_NAME;
            $_SESSION['curPage'] = 'dashboard';
            $reqFiles->get_header($pageName);

            if (isset($_SESSION['type'])) {
                require _DIR ."/etc/link/links.php";
                $links = new links();
                $links->setConn($conn);
                $link_ret = $links->getLinks($userDetail['Id']);
                require _DIR . "/etc/jobs/appliedJob.php";
                $applyJob = new appliedJob();
                if ($_SESSION['type'] == 'J' && $userDetail['user_type'] == 'J') {
                    require "jobseeker.php";
                } else {
                    require "organisation.php";
                }
            }
            ?>
            <p class="hiddenUrl base"><?php echo _HOME; ?></p>
            <p class="hiddenUrl verify"></p>
            <script type="text/javascript">
                // user country code for selected option
                let user_country_code = "IN";
                let user_state_name = '';
                let user_state_code= '';

                if($('#country-id').val()!==''){
                    user_country_code = '';
                    user_country_name = $('#country-id').val();
                }
                if($('#state-id').val()!==''){
                    user_state_name = $('#state-id').val();
                }
                (function () {
                    let country_list = country_and_states['country'];
                    let states_list = country_and_states['states'];
                    if(user_country_code==''){
                        $.each(country_list,function(index,element){
                            if(user_country_name == element){
                                user_country_code = index;
                            }
                        });
                    }
                    if(user_state_name!=''){
                        $.each(states_list[user_country_code],function(index,element){
                            if(user_state_name == element.name){
                                user_state_code = element.code;
                            }
                        });
                    }
                    // creating country name drop-down
                    let option = '';
                    option += '<option>select country</option>';
                    for (let country_code in country_list) {
                        // set selected option user country
                        let selected = (country_code == user_country_code) ? ' selected' : '';
                        option += '<option value="' + country_list[country_code] + '"' + selected + ' data-code="' + country_code + '" >' + country_list[country_code] + '</option>';
                    }
                    document.getElementById('country').innerHTML = option;

                    // creating states name drop-down
                    let text_box = '<input type="text" name="state" class="input-text" id="state">';
                    let state_code_id = document.getElementById("state-code");

                    function create_states_dropdown() {
                        // get selected country code
                        let country_code = document.getElementById("country");
                        var value = country_code.options[country_code.selectedIndex].getAttribute("data-code");
                        let states = states_list[value];
                        // invalid country code or no states add textbox
                        if (!states) {
                            state_code_id.innerHTML = text_box;
                            return;
                        }
                        let option = '';
                        if (states.length > 0) {
                            option = '<select name="state" id="state">\n';
                            for (let i = 0; i < states.length; i++) {
                                let selected_code = (states[i].code==user_state_code)?'selected':'';
                                option += '<option value="' + states[i].name + '" '+ selected_code + '>' + states[i].name + '</option>';
                            }
                            option += '</select>';
                        } else {
                            // create input textbox if no states
                            option = text_box
                        }
                        state_code_id.innerHTML = option;
                    }

                    // country select change event
                    const country_select = document.getElementById("country");
                    country_select.addEventListener('change', create_states_dropdown);
                    create_states_dropdown();
                })();

            </script>

        <?php    $reqFiles->get_footer();
        } else {
            header("location:"._HOME.'/index.php');
        }
    else:
        defined("OWNER") or die("You are not allowed to access");
    endif;
else:
    header("location: " . _HOME . "/index.php");
endif; ?>
