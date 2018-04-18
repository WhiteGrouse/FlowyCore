<?php
namespace Flowy;

use pocketmine\event\Event;

if(!class_exists('Flowy\ListenAwaitable')){

class ListenAwaitable extends Awaitable{
	/** @var string[] */
	protected $targets = [];

	/** @var callable[] */
	protected $filters = [];

	public function filter(callable $filter){
		$this->filters[] = $filter;
		return $this;
	}

	public function timeout(callable $flow, int $tick, bool $continueWhenDone = false){
		return $this->branch(function() use ($flow, $tick){
			yield \Flowy\delay($tick);
			yield from $flow();
		}, $continueWhenDone);
	}

	public function addListenTarget(string $event){
		if(!is_subclass_of($event, Event::class))
		if(!in_array($event, $this->targets))
			$this->target[] = $event;
	}

	public function getTargetEvents(){
		return $this->targets;
	}

	public function getFilters(){
		return $this->filters;
	}
}

}// class_exists