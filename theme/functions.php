<?php
/**
 * Loader for %%THEMENAME%% classes, functions, etc.
 *
 * @package %%PACKAGENAME%%
 */

namespace %%VARPREFIX%%\theme;

require_once __DIR__ . '/inc/class-%%CLASSFILENAME%%.php';

( new %%CLASSNAME%%() )->initialize();
