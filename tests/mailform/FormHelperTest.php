<?php

declare(strict_types=1);

namespace mailform;

use PHPUnit\Framework\TestCase;

final class FormHelperTest extends TestCase
{
    public function testFilteringOnUserInput(): void
    {
        $this->assertEquals('//woo&amp;&quot;', FormHelper::filterUserInput('   \\//woo&"'));
    }
}


