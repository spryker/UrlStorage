<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Installer\Dependency\Facade;

use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\TranslationTransfer;
use Spryker\Zed\Glossary\Business\Exception\KeyExistsException;
use Spryker\Zed\Glossary\Business\Exception\MissingKeyException;
use Spryker\Zed\Glossary\Business\Exception\MissingTranslationException;
use Spryker\Zed\Glossary\Business\Exception\TranslationExistsException;
use Spryker\Zed\Locale\Business\Exception\MissingLocaleException;

class InstallerToGlossaryBridge implements InstallerToGlossaryInterface
{

    /**
     * @var \Spryker\Zed\Glossary\Business\GlossaryFacade
     */
    protected $glossaryFacade;

    /**
     * @param \Spryker\Zed\Glossary\Business\GlossaryFacade $glossaryFacade
     */
    public function __construct($glossaryFacade)
    {
        $this->glossaryFacade = $glossaryFacade;
    }

    /**
     * @param string $keyName
     *
     * @return int
     */
    public function createKey($keyName)
    {
        return $this->glossaryFacade->createKey($keyName);
    }

    /**
     * @param string $keyName
     *
     * @return bool
     */
    public function hasKey($keyName)
    {
        return $this->glossaryFacade->hasKey($keyName);
    }

    /**
     * @param string $keyName
     * @param LocaleTransfer|null $locale
     *
     * @return bool
     */
    public function hasTranslation($keyName, LocaleTransfer $locale = null)
    {
        return $this->glossaryFacade->hasTranslation($keyName, $locale);
    }

    /**
     * @param string $keyName
     * @param LocaleTransfer $locale
     *
     * @return TranslationTransfer
     */
    public function getTranslation($keyName, LocaleTransfer $locale)
    {
        return $this->glossaryFacade->getTranslation($keyName, $locale);
    }

    /**
     * @param string $keyName
     * @param LocaleTransfer $locale
     * @param string $value
     * @param bool $isActive
     *
     * @return TranslationTransfer
     */
    public function createAndTouchTranslation($keyName, LocaleTransfer $locale, $value, $isActive = true)
    {
        return $this->glossaryFacade->createAndTouchTranslation($keyName, $locale, $value, $isActive);
    }

    /**
     * @param string $keyName
     * @param LocaleTransfer $locale
     * @param string $value
     * @param bool $isActive
     *
     * @return TranslationTransfer
     */
    public function updateAndTouchTranslation($keyName, LocaleTransfer $locale, $value, $isActive = true)
    {
        return $this->glossaryFacade->updateAndTouchTranslation($keyName, $locale, $value, $isActive);
    }


}