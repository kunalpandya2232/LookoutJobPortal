<?php

session_start();
require "../config/settingsFiles.php";

use config\settingsFiles\settingsFiles as settings;
$configFiles = new settings();
$configFiles->get_required_files();
$_SESSION['cur_page'] = 'jobseeker';
$pageName             = "Manage Jobseeker" . SITE_NAME;
$configFiles->get_header_admin($pageName);
?>


<div class="page-wrapper">
    <div class="content">
        <?php if(isset($_SESSION['user_register']) && $_SESSION['user_register']=='new'):?>
            <div class="row">
                <div class="col-sm-4 col-3">
                    New User Added
                </div>
            </div>
        <?php endif;?>
        <div class="row">
            <div class="col-sm-4 col-3">
                <h4 class="page-title">Jobseeker</h4>
            </div>
            <div class="col-sm-8 col-9 text-right m-b-20">
                <a href="<?php echo _ADMIN_HOME.'/user/add.php?user=jobseeker';?>" class="btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add
                    Jobseeker</a>
            </div>
        </div>
        <div class="search-filter">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="">
                <input type="hidden" value="J" class="u_type">

                <div class="col-md-4 col-sm-5">
                    <div class="filter-form">
                        <div class="input-group">
                            <input type="text" class="form-control search-value" placeholder="Search… By Location" >
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" id="search-go-button">Go</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-7">
                    <div class="short-by pull-right">
                        Sort By
                        <div class="dropdown select-button-sort">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <i
                                        class="fa fa-angle-down" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu">
                                <li class="select-option"><a href="#" data-sort="date">Sort By Date</a></li>
                                <li class="select-option"><a href="#" data-sort="name">Sort By Name</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row" id="getOrg">

        </div>
        <div class="row" id="getOrgButton">
            <div class="col-sm-12 col-md-7">
                <ul class="pagination">

                </ul>
            </div>
        </div>

        <div class="modal fade" id="editForm_modal" aria-labelledby="editFormLabel"
             tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="editFormLabel">Edit User</h3>
                        <button class="btn btn-primary float-right" data-target="#editForm_modal"
                                data-dismiss="modal"><i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"
                              name="jobseeker_edit_form" method="post"
                              class="" id="editForm">
                            <div class="col-md-6 col-sm-12">
                                <label>First Name</label>
                                <input type="text" name="fname" id="fname" class="form-control" value="" required>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label>Last Name</label>
                                <input type="text" name="lname" id="lname" class="form-control" value="" required>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <label>Mobile Number</label>
                                <input type="number" name="contact_no" id="contact_no" class="form-control" value="">
                            </div>

                            <div class=" col-md-6 col-sm-6">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" id="dob" class="form-control" value="" required>
                            </div>
                            <div class="col-md-8 col-sm-6">
                                <label>Address</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="" value=""
                                       maxlength="150" required>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <label>City</label>
                                <input type="text" class="form-control" id="city"
                                       value="">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <input type="hidden" id="state-id" value="">
                                <label>State</label>
                                <span id="state-code">
                                                <input type="text" name="state" class="d-block" id="state">
                                            </span>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <input type="hidden" id="country-id" value="">
                                <label>Country</label>
                                <select name="country" id="country">
                                    <option>select country</option>
                                </select>
                            </div>

                            <div class="col-md-12 col-sm-12"
                                 style="padding-right:15px;padding-left:15px; margin-top:10px!important; margin-bottom: 25px!important;">
                                <label>Gender</label>
                                <span style="padding-left:50px; ">Male</span>
                                <input type="radio" name="gender" class="gender" id="gender_male"
                                       value="M" <?php echo isset($userDetail['gender']) && $userDetail['gender'] == "M" ? 'checked' : ''; ?>>
                                <span style="padding-left:50px; ">Female</span>

                                <input type="radio" name="gender" class="gender" id="gender_female"
                                       value="F" <?php echo isset($userDetail['gender']) && $userDetail['gender'] == "F" ? 'checked' : ''; ?>>
                                <span style="padding-left:50px; ">Others</span>
                                <input type="radio" name="gender" class="gender" id="gender_othermale"
                                       value="N" <?php echo isset($userDetail['gender']) && $userDetail['gender'] == "N" ? 'checked' : ''; ?>>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <label>Organization Name</label>
                                <input type="text" name="orgName" class="form-control" id="orgName"
                                       value="">
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <label>User Experience</label>
                                <input type="number" name="user_exp" class="form-control" id="user_exp"
                                       value="">
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <label>User Occupation</label>
                                <input type="text" name="user_occ" class="form-control" id="user_occ"
                                       value="">
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <label>Password</label>
                                <input type="password" class="form-control" id="newpass" placeholder="Password">
                            </div>
                            <div class="col-sm-12">
                                <input type="hidden" id="uid" value="">

                                <button type="submit" name="submit" id="submi-edit-profile" class="update-btn">Update User
                                </button>
                            </div>
                        </form>
                    </div>
                    <button class="btn btn-primary" data-target="#editForm_modal"
                            data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
        <div id="delete_organization" class="modal fade delete-modal" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <img src="assets/img/sent.png" alt="" width="50" height="46">
                        <h3>Are you sure want to delete this Jobseeker?</h3>
                        <div class="m-t-20"><a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                            <button type="submit" class="btn btn-danger del_button" >Bann</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    // user country code for selected option
    let user_country_code = "IN";
    let user_state_code = "Andaman and Nicobar Islands";

    (function () {
        let country_list = country_and_states['country'];
        let states_list = country_and_states['states'];

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
        let text_box = '<input type="text" name="state" class="input-text form-control" id="state">';
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
                    let selected_code = (states[i].name == user_state_code) ? 'selected' : '';
                    option += '<option value="' + states[i].name + '" ' + selected_code + '>' + states[i].name + '</option>';
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
<?php
$configFiles->get_footer_admin();
?>
