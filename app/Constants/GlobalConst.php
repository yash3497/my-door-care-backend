<?php

namespace App\Constants;

class GlobalConst
{
    const USER_PASS_RESEND_TIME_MINUTE = "1";
    const USER_VERIFY_RESEND_TIME_MINUTE = 0.5;

    const ACTIVE = true;
    const SUCCESS = true;
    const BANNED = false;
    const DEFAULT_TOKEN_EXP_SEC = 3600;

    const VERIFIED = 1;
    const APPROVED = 1;
    const PENDING = 2;
    const REJECTED = 3;
    const DEFAULT = 0;
    const UNVERIFIED = 0;

    const UNKNOWN = "UNKNOWN";

    const SETUP_PAGE = 'SETUP_PAGE';
    const SYSTEM_MAINTENANCE       = "system-maintenance";
    const USEFUL_LINK_PRIVACY_POLICY = "PRIVACY_POLICY";
}
