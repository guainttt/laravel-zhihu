<?php 
namespace App\Repositories;

use App\Message;

/**
 * 私信仓库
 */
class MessageRepository
{
	/**
	 *	创建私信
	 */
	public function CreateMessage($attributes)
	{
		return Message::create($attributes);
	}
}