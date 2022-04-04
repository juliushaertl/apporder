<?php

namespace OCA\AppOrder\Listener;

use OCP\EventDispatcher\Event;

class BeforeTemplateRenderedListener implements \OCP\EventDispatcher\IEventListener {

	/**
	 * @inheritDoc
	 */
	public function handle(Event $event): void {
		\OCP\Util::addStyle('apporder', 'apporder');
		\OCP\Util::addScript('apporder', 'apporder');
	}
}
