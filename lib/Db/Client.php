<?php

declare(strict_types=1);
// SPDX-FileCopyrightText: C.Schmidt <github@marchron.de>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\MyProjectTracker\Db;

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

/**
 * @method getId(): int
 * @method getTitle(): string
 * @method setTitle(string $title): void
 * @method getActive(): int
 * @method setActive(int $active): void
 * @method getUserId(): string
 * @method setUserId(string $userId): void
 */
class Client extends Entity implements JsonSerializable {
	protected string    $title = '';
	protected int      $active = 1;
	protected string    $userId = '';

	public function jsonSerialize(): array {
		return [
			'id' => $this->id,
			'title' => $this->title,
			'active' => ( $this->active == 1 ? true : false )
		];
	}
}
