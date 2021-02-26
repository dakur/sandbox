<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Routing\Route;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;

		// campaign id only works
		$router->addRoute('campaign/<campaignId>', [
			'presenter' => 'Campaign',
			'action' => 'default',
			'campaignId' => [
				Route::PATTERN => '[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}', // UUID
				Route::FILTER_IN => static fn(string $campaignId) => CampaignId::of($campaignId),
				Route::FILTER_OUT => static fn(CampaignId $campaignId) => $campaignId->toString(),
			],
		]);

		// uncomment to see that static campaign id works
//		$router->addRoute('campaign/cab32440-1a03-4b26-86a6-d44e444d25f2/<version>', [
//			'presenter' => 'Campaign',
//			'action' => 'default',
//			'version' => [
//				Route::PATTERN => 'working-draft',
//				Route::VALUE => new WorkingDraft(),
//				Route::FILTER_IN => static fn(string $version) => new WorkingDraft(),
//				Route::FILTER_OUT => static fn(WorkingDraft $version) => 'working-draft',
//			],
//		]);

		// version only works
		$router->addRoute('campaign/<version>', [
			'presenter' => 'Campaign',
			'action' => 'default',
			'version' => [
				Route::PATTERN => 'working-draft',
				Route::VALUE => new WorkingDraft(),
				Route::FILTER_IN => static fn(string $version) => new WorkingDraft(),
				Route::FILTER_OUT => static fn(WorkingDraft $version) => 'working-draft',
			],
		]);

		// campaign id & version does not work, canonicalization incorrectly redirects to /campaign/<campaignId>
		$router->addRoute('campaign/<campaignId>/<version>', [
			'presenter' => 'Campaign',
			'action' => 'default',
			'campaignId' => [
				Route::PATTERN => '[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}', // UUID
				Route::FILTER_IN => static fn(string $campaignId) => CampaignId::of($campaignId),
				Route::FILTER_OUT => static fn(CampaignId $campaignId) => $campaignId->toString(),
			],
			'version' => [
				Route::PATTERN => 'working-draft',
				Route::VALUE => new WorkingDraft(),
				Route::FILTER_IN => static fn(string $version) => new WorkingDraft(),
				Route::FILTER_OUT => static fn(WorkingDraft $version) => 'working-draft',
			],
		]);

		return $router;
	}
}
