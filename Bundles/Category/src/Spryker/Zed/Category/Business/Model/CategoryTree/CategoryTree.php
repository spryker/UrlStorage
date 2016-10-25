<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Category\Business\Model\CategoryTree;

use Spryker\Zed\Category\Business\CategoryFacadeInterface;
use Spryker\Zed\Category\Persistence\CategoryQueryContainerInterface;

class CategoryTree implements CategoryTreeInterface
{

    /**
     * @var \Spryker\Zed\Category\Persistence\CategoryQueryContainerInterface
     */
    protected $queryContainer;

    /**
     * @var \Spryker\Zed\Category\Business\CategoryFacadeInterface
     */
    protected $categoryFacade;

    /**
     * @param \Spryker\Zed\Category\Persistence\CategoryQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\Category\Business\CategoryFacadeInterface $categoryFacade
     */
    public function __construct(CategoryQueryContainerInterface $queryContainer, CategoryFacadeInterface $categoryFacade)
    {
        $this->queryContainer = $queryContainer;
        $this->categoryFacade = $categoryFacade;
    }

    /**
     * @param int $idSourceCategoryNode
     * @param int $idDestinationCategoryNode
     *
     * @return void
     */
    public function moveSubTree($idSourceCategoryNode, $idDestinationCategoryNode)
    {
        $firstLevelChildNodeCollection = $this
            ->queryContainer
            ->queryFirstLevelChildren($idSourceCategoryNode)
            ->find();

        foreach ($firstLevelChildNodeCollection as $childNodeEntity) {
            $categoryTransfer = $this->categoryFacade->read($childNodeEntity->getFkCategory());

            $categoryNodeTransfer = $categoryTransfer->getCategoryNode();
            $categoryNodeTransfer->setFkParentCategoryNode($idDestinationCategoryNode);
            $categoryTransfer->setCategoryNode($categoryNodeTransfer);

            $categoryParentNodeTransfer = $categoryTransfer->getParentCategoryNode();
            $categoryParentNodeTransfer->setIdCategoryNode($idDestinationCategoryNode);
            $categoryTransfer->setParentCategoryNode($categoryParentNodeTransfer);

            $this->categoryFacade->update($categoryTransfer);
        }
    }

}
