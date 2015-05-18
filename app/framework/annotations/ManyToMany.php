<?php
/**
 * Annotation ManyToMany
 * @author jc
 * @version 1.0.0.1
 * @package annotations
 * @Target("property")
 */
class ManyToMany extends Annotation{
	public $targetEntity;
	public $inversedBy;
	public $mappedBy;
}