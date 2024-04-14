<?php



$localurl = explode('/', $props['gets']['url'])[0];
unset($props['gets']['url']);
$pageCount = floor($props['totalResults'] / $props['limit']);


if ($props['totalResults'] >  $props['limit']) {
?><nav class="text-center mt-3">
        <ul class="pagination-box">
            <?php if ($props['page'] == 1) { ?>
                <li>
                <li class="d-inline-block d-md-none">
                    <span><i class="fas fa-chevron-left"></i><i class="fas fa-chevron-left"></i></span>
                </li>
                <li>
                    <span><i class="fas fa-chevron-left"></i></span>
                </li>
            <?php } else { ?>
                <li class="d-inline-block d-md-none">
                    <a href="<?php echo mountPaginationUrl($localurl, 1, $props['gets']); ?>">
                        <i class="fas fa-chevron-left"></i>
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
                <li>
                    <a href="<?php echo mountPaginationUrl($localurl, $props['page'] - 1, $props['gets']); ?>"><i class="fas fa-chevron-left"></i></a>
                </li>
            <?php } ?>



            <?php if ($pageCount < 6) {
                for ($i = 1; $i <= $pageCount; $i++) { ?>
                    <li class="<?php if ($i == $props['page']) {
                                    echo ' active';
                                } else {
                                    echo 'd-none d-md-inline-block';
                                } ?>"><a href="<?php echo mountPaginationUrl($localurl, $i, $props['gets']); ?>"><?php echo $i; ?></a></li>
                <?php }
            } else {
                if ($props['page'] > 2) { ?>
                    <li class="<?php if ($i == $props['page']) {
                                    echo ' active';
                                } else {
                                    echo 'd-none d-md-inline-block';
                                } ?>"><a href="<?php echo mountPaginationUrl($localurl, 1, $props['gets']); ?>">1</a></li>

                <?php }
                if ($props['page'] > 3) { ?>
                    <li>
                        <span class="d-none d-md-inline-block">...</span>
                    </li> <?php
                        }

                        $prev = $props['page'] - 1;
                        $next = $props['page'] + 1;
                        if ($props['page'] == $pageCount) {
                            ?>
                    <li class="d-none d-md-inline-block"><a href="<?php echo mountPaginationUrl($localurl, $prev - 1, $props['gets']); ?>"><?php echo $prev - 1; ?></a></li>
                <?php
                        }
                        if ($prev) {
                ?>
                    <li class="d-none d-md-inline-block"><a href="<?php echo mountPaginationUrl($localurl, $prev, $props['gets']); ?>"><?php echo $prev; ?></a></li>

                <?php
                        }

                ?> <li class="active"><a href="<?php echo mountPaginationUrl($localurl, $props['page'], $props['gets']); ?>"><?php echo $props['page']; ?></a></li>
                <?php

                if ($next <= $pageCount) {
                ?>
                    <li class="d-none d-md-inline-block"><a href="<?php echo mountPaginationUrl($localurl, $next, $props['gets']); ?>"><?php echo $next; ?></a></li>

                <?php
                }

                if ($props['page'] == 1) {
                ?>
                    <li class="d-none d-md-inline-block"><a href="<?php echo mountPaginationUrl($localurl, $next + 1, $props['gets']); ?>"><?php echo $next + 1; ?></a></li>
                <?php
                }

                if ($props['page'] < $pageCount - 3) {
                ?>
                    <li>
                        <span class="d-none d-md-inline-block">...</span>
                    </li> <?php
                        }
                        if ($props['page'] < $pageCount - 2) { ?>
                    <li class="<?php if ($i == $props['page']) {
                                    echo ' active';
                                } else {
                                    echo 'd-none d-md-inline-block';
                                } ?>"><a href="<?php echo mountPaginationUrl($localurl, $pageCount, $props['gets']); ?>"><?php echo $pageCount; ?></a></li>

            <?php }
                    } ?>

            <?php if ($props['page'] == $pageCount) { ?> <li>
                    <span><i class="fas fa-chevron-right"></i></span>
                </li>
                <li class="d-inline-block d-md-none">
                    <span><i class="fas fa-chevron-right"></i></span>
                    <span><i class="fas fa-chevron-right"></i></span>
                </li>


            <?php } else { ?>
                <li>
                    <a href="<?php echo mountPaginationUrl($localurl, $props['page'] + 1, $props['gets']); ?>"><i class="fas fa-chevron-right"></i></a>
                </li>
                <li class="d-inline-block d-md-none">
                    <a href="<?php echo mountPaginationUrl($localurl, $pageCount, $props['gets']); ?>"><i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></a>
                </li>


            <?php }  ?>
        </ul>
    </nav>
<?php } ?>