<?php

namespace AppBundle;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function boot()
    {
        foreach (['apiName', 'apiGroup', 'apiParam', 'apiSuccess', 'apiError', 'apiVersion'] as $annotation) {
            AnnotationReader::addGlobalIgnoredName($annotation);
        }
        parent::boot();
    }
}
