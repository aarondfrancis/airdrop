<?php
/**
 * @author Aaron Francis <aarondfrancis@gmail.com>
 */

namespace Hammerstone\Airdrop\Contracts;


interface StashAndRestoreDriverContract
{

    public function stash();

    public function restore();

}