<?php
/**
 * Pop PHP Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.TXT.
 * It is also available through the world-wide-web at this URL:
 * http://www.popphp.org/LICENSE.TXT
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@popphp.org so we can send you a copy immediately.
 *
 * @category   Pop
 * @package    Pop_Pdf
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

require_once dirname(__FILE__) . '/../../library/Pop/Autoloader.php';
Pop_Autoloader::bootstrap();

class Pop_PdfTest extends PHPUnit_Framework_TestCase
{

    public function testPdfConstructor()
    {
        $p = new Pop_Pdf('new_pdf.pdf');
        $class = 'Pop_Pdf';
        $this->assertTrue($p instanceof $class);
    }

    public function testPdfConstructorImport()
    {
        $p = new Pop_Pdf('../../public/examples/assets/pdfs/hospital_template.pdf');
        $this->assertEquals(2, $p->numPages());
    }

    public function testPdfImport()
    {
        $p = new Pop_Pdf('new_pdf.pdf');
        $p->addPage('Letter');
        $p->importPdf('../../public/examples/assets/pdfs/hospital_template.pdf');
        $this->assertEquals(3, $p->numPages());
    }

    public function testPdfNumPages()
    {
        $p = new Pop_Pdf('new_pdf.pdf');
        $this->assertEquals(0, $p->numPages());
    }

    public function testPdfAddPage()
    {
        $p = new Pop_Pdf('new_pdf.pdf', 'Letter');
        $p->addPage('Letter');
        $this->assertEquals(2, $p->numPages());
    }

    public function testPdfCopyPage()
    {
        $p = new Pop_Pdf('new_pdf.pdf', 'Letter');
        $p->addPage('Letter');
        $p->copyPage(2);
        $this->assertEquals(3, $p->numPages());
    }

    public function testPdfDeletePage()
    {
        $p = new Pop_Pdf('new_pdf.pdf', 'Letter');
        $p->addPage('Letter');
        $p->deletePage(2);
        $this->assertEquals(1, $p->numPages());
    }

    public function testPdfCurPage()
    {
        $p = new Pop_Pdf('new_pdf.pdf', 'Letter');
        $p->addPage('Letter');
        $this->assertEquals(2, $p->curPage());
    }

    public function testPdfSetPage()
    {
        $p = new Pop_Pdf('new_pdf.pdf', 'Letter');
        $p->addPage('Letter');
        $p->setPage(1);
        $this->assertEquals(1, $p->curPage());
    }

}

?>