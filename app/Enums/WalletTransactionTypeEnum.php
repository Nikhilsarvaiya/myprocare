<?php

namespace App\Enums;

enum WalletTransactionTypeEnum: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
 }
