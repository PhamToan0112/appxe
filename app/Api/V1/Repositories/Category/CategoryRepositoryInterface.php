<?php

namespace App\Api\V1\Repositories\Category;

interface CategoryRepositoryInterface
{
    public function getTree();  
    public function getCategoryActive();  
    public function findByIdOrSlug($idOrSlug);

    public function findByIdOrSlugWithAncestorsAndDescendants($idOrSlug);

    public function getRootWithAllChildren();
}