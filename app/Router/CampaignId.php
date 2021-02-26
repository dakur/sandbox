<?php declare(strict_types = 1);


namespace App\Router;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;


final class CampaignId
{
	private function __construct(
		private UuidInterface $uuid,
	) {}

	public static function of(string $uuid): self
	{
		return new self(Uuid::fromString($uuid));
	}

	public function toString(): string
	{
		return (string) $this->uuid;
	}
}
