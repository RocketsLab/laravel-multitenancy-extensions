<?php

namespace RocketsLab\MultitenancyExtensions\Jobs;

use Spatie\Multitenancy\Jobs\NotTenantAware;
use Stancl\JobPipeline\JobPipeline;

class ProcessTenantCreation extends JobPipeline implements NotTenantAware
{

}
