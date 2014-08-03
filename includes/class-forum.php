<?php
class Forum {
	public function getPosts($first = NULL, $last = NULL, $num = NULL) {
		if (!$num) {
			$num = $this->config->initialPostNum();
		}

		echo $num;
	}
}
?>