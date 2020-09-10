<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConstantsHelper extends Model
{
    // MARK: - SIGN DIRECTION
    const SIGN_DIRECTION = "/Users/abdullah/Downloads/zsign/zsign";

    // MARK: - KEY
    const STORE_KEY = "ASD&*(534AS4D@#ABDULLAH_MOTLAQ_ALOTAIBI";
    const STORE_KEY_IV = "ABDULLAH_MOTLAQ_ALOTAIBI@54$564da58s56";

    // MARK: - STATUS GROUPS
    const NEED_UPDATE_LOGIN_APPLE_DEVELOPER = "9";
    const ACTIVE_GROUP = "1";
    const DISABLED_GROUP = "2";

    // MARK: - STATUS Customer
    const NEED_UPDATE_PROFILE_CUSTOMER = "9";
    const ACTIVE_CUSTOMER = "1";
    const DISABLED_CUSTOMER = "2";
    const NEW_ORDERS_CUSTOMER = "8";

}
