<?php

namespace App;

enum CredentialType: string
{
    case Bearer_Auth = 'Bearer-Auth';

    case Basic_Auth = 'Basic-Auth';
    
    case Digest_Auth = 'Digest-Auth';
}
