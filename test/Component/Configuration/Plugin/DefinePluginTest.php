<?php
namespace Hostnet\Component\WebpackBridge\Configuration\Plugin;

use Hostnet\Component\WebpackBridge\Configuration\CodeBlock;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * @covers Hostnet\Component\WebpackBridge\Configuration\Plugin\DefinePlugin
 * @author Harold Iedema <hiedema@hostnet.nl>
 */
class DefinePluginTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigTreeBuilder()
    {
        $tree = new TreeBuilder();
        $node = $tree->root('webpack')->children();

        DefinePlugin::applyConfiguration($node);
        $node->end();

        $config = $tree->buildTree()->finalize([]);
    }

    public function testGetCodeBlock()
    {
        $config = new DefinePlugin([
            'plugins' => [
                'constants' => [
                    'foo' => 'bar'
                ]
            ]
        ]);

        $config->add('bar', 'baz');

        $this->assertEquals(
            'new webpack.DefinePlugin({"foo":"bar","bar":"baz"})',
            $config->getCodeBlock()->get(CodeBlock::PLUGIN)
        );
    }
}
