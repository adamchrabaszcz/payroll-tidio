<?php

namespace Domain\Model;

enum BonusType: string
{
    case FIXED = 'fixed';
    case PERCENTAGE = 'percentage';
}
