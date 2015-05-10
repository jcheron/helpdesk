<?php

/** @Target("property") */
class ManyToMany extends Annotation{
	public $targetEntity;
	public $inversedBy;
	public $mappedBy;
}