<?php

require_once('tcpdf/tcpdf.php');

class PDF extends TCPDF {
	protected $font_stack = array();
	public $current_font = NULL;

	public static $document_orientation = 'P';
	public static $document_format = 'Letter';

	public $header;
	public $footer;
	public $background_img;

	public $document_color = 'gray';

	private $last_height = 0;
	private $last_width = 0;
	private $separator = 5;
	private $document_width;

	public function __construct($orientation='P', $format="Letter", $color='gray') {
		parent::__construct($orientation, "pt", $format);
		self::$document_orientation = $orientation;
		self::$document_format = $format;
		$margins = parent::getMargins();
		$this->document_width = parent::getPageWidth() - $margins['left'] - $margins['right'];
		$this->last_width = $margins['left'];
		$this->last_height = $margins['top'];

		$this->document_color = $color;
		if ($color == 'red')
			parent::SetDrawColorArray(array(255, 128, 128));
		elseif ($color == 'green')
			parent::SetDrawColorArray(array(128, 255, 128));
		elseif ($color == 'blue')
			parent::SetDrawColorArray(array(128, 128, 255));
		else
			parent::SetDrawColorArray(array(128, 128, 128));

		parent::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		parent::SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
		parent::setImageScale(PDF_IMAGE_SCALE_RATIO);
		parent::SetHeaderMargin(PDF_MARGIN_HEADER);
		parent::SetFooterMargin(PDF_MARGIN_FOOTER + 10);
	}

	public function add_font($font) {
		if (isset($this->current_font))
			array_push($this->font_stack, $this->current_font);

		$this->current_font = $font;

		parent::SetFont($font->tipo, $font->estilo, $font->tamano);
		parent::SetTextColorArray($font->color);
	}

	public function add_page($orientation='', $format='') {
		if (empty($orientation))
			$orientation = self::$document_orientation;

		if (empty($format))
			$format = self::$document_format;

		parent::AddPage($orientation, $format);
		$this->last_width = 0;
		$this->last_height = 0;
	}

	public function reestablish_font() {
		$this->current_font = NULL;
		$new_font = array_pop($this->font_stack);
		if (!isset($new_font))
			$new_font = $this->get_current_font();
		$this->add_font($new_font);
	}

	public function get_current_font() {
		if (isset($this->current_font))
			return $this->current_font;
		
		$font = new stdClass();
		$font->tipo = "helvetica";
		$font->estilo = "";
		$font->tamano = 10;
		$font->color = array(0, 0, 0);
		return $font;
	}

	public function add_frame($frame) {
		$absolute_position = $this->is_absolute($frame);
		if (!$absolute_position)
			$this->validate_position($frame->ancho);

		$x = parent::GetX();
		$y = parent::GetY();
		$title_height = 0;

		if (isset($frame->titulo)) {
			if ($frame->fondo)
				$this->choose_color();

			$current_font = $this->get_current_font();
			$this->SetFont($current_font->tipo, $current_font->estilo, $current_font->tamano + 1);
			parent::WriteHTMLCell($frame->ancho, 0,
				                    $x,
				                    $y,
				                    "<b>".$frame->titulo."</b>",
				                    $frame->borde,      0, 1, true, 'C');
			parent::Ln();
			parent::SetFillColorArray(array(255, 255, 255));
			$this->SetFont($current_font->tipo, $current_font->estilo, $current_font->tamano);
			$title_height = parent::getLastH();
			parent::SetX($x);
		}

		parent::WriteHTMLCell($frame->ancho,
			                    $frame->altura,
			                    $x,
			                    parent::GetY(),
			                    $frame->texto,
			                    $frame->borde,       0, 0, true,
			                    $frame->alineacion);

		parent::SetXY(parent::GetX() + $this->separator, $y);
		if ($absolute_position)
			$this->last_width = parent::GetX();
		$y = parent::GetY() + parent::getLastH() + $title_height;
		if ($y > $this->last_height)
			$this->last_height = $y;
	}

	private function is_absolute($element) {
		if (isset($element->y)) {
			parent::SetY($element->y);
			return true;
		}
		if (isset($element->x)) {
			parent::SetX($element->x);
			return true;
		}

		return false;
	}

	private function choose_color() {
		if ($this->document_color == 'blue')
			parent::SetFillColorArray(array(168, 200, 255));
		elseif ($this->document_color == 'red')
			parent::SetFillColorArray(array(255, 168, 200));
		elseif ($this->document_color == 'green')
			parent::SetFillColorArray(array(200, 255, 168));
		else
			parent::SetFillColorArray(array(220, 220, 220));
	}

	private function validate_position($width) {
		$margins = parent::getMargins();

		if ($width == 0)
			$width = $this->document_width - $this->last_width;

		$x_width = parent::GetX() + $width;

		if ($x_width > $this->document_width || parent::GetX() >= $this->document_width) {
			parent::SetY($this->last_height + $this->separator);
			$x_width = $margins['left'] + $width;
		}

		if (parent::GetY() < $this->last_height) {
			parent::SetX($this->last_width);
			$x_width = $this->last_width + $width;
		}

		if (parent::GetY() >= parent::getPageHeight() - $margins['bottom'])
			$this->add_page();

		if ($x_width < $this->document_width)
			$this->last_width = $x_width + $this->separator;
	}

	public function add_image($image) {
		$absolute_position = $this->is_absolute($image);
		if (!$absolute_position)
			$this->validate_position($image->ancho);

		$image_size = getimagesize($image->url);

		if (!isset($image->ancho))
			$width = $image_size[1];
		else
			$width = $image->ancho;
		
		parent::Image($image->url,
			            parent::GetX(),
			            parent::GetY(),
			            $image->ancho,
			            $image->altura,     '', '', '', true, 300,
			            $image->alineacion, '', '',
			            $image->borde,      false, false, true);

		$y = parent::getImageRBY();
		parent::SetX(parent::getImageRBX());
		if ($y > $this->last_height)
			$this->last_height = $y;

		if ($absolute_position)
			$this->last_width = parent::GetX();
	}

	public function add_table($table) {
		$absolute_position = $this->is_absolute($table);
		if (!$absolute_position)
			$this->validate_position($table->ancho);

		if ($table->fondo)
			$this->choose_color();
		$this->SetLineWidth(0.3);

		// set the width of the table
		$margins = parent::getMargins();
		if ($table->ancho == 0) {
			if (parent::GetX() == $margins['left'])
				$table->ancho = $this->document_width;
			elseif (isset($table->x))
				$table->ancho = $this->document_width - $table->x;
			else
				$table->ancho = $this->document_width - $this->last_width;
		}

		// get the widths of the headers
		$encabezados = (array) $table->encabezados;
		$string_widths = 0;
		$has_superheaders = false;
		foreach ($encabezados as $key => $cell)
			if (is_array($cell)) {
				$has_superheaders = true;
				foreach ($cell as $value)
					$string_widths += parent::GetStringWidth($value);
			}
			else
				$string_widths += parent::GetStringWidth($cell);

		if ($table->borde == 0) {
			$header_border = 'B';
			$data_border = 0;
		}
		else {
			$header_border = 1;
			$data_border = 'LR';
		}

		// print headers
		$x = parent::GetX();
		$y = parent::GetY();
		$widths = array();
		$i = 0;
		if ($has_superheaders)
			$cell_h = 26;
		else
			$cell_h = 13;
		foreach ($encabezados as $index => $cell) {
			if (is_array($cell)) {
				$super_w = 0;
				$super_x = parent::GetX();
				foreach ($cell as $key => $value) {
					array_push($widths, $this->GetStringWidth($value) / $string_widths * $table->ancho);
					parent::WriteHTMLCell($widths[$i + $key], $cell_h / 2, parent::GetX(), $y + $cell_h / 2, "<b>".$value."</b>", $header_border, 0, $table->fondo, true, 'C');
					$super_w += $widths[$i + $key];
				}
				parent::WriteHTMLCell($super_w, $cell_h / 2, $super_x, $y, "<b>".$index."</b>", $header_border, 0, $table->fondo, true, 'C');
				parent::SetXY(parent::GetX(), $y + $cell_h / 2);
			}
			else {
				array_push($widths, $this->GetStringWidth($cell) / $string_widths * $table->ancho);
				parent::WriteHTMLCell($widths[$index], $cell_h, parent::GetX(), $y, "<b>".$cell."</b>", $header_border, 0, $table->fondo, true, 'C');
			}
			$i++;
		}
		parent::Ln();
		parent::SetX($x);

		// print data
		$fill = false;
		foreach($table->datos as $row) {
			foreach ($row as $i => $field)
				$this->WriteHTMLCell($widths[$i], 6, '', '', $field, $data_border, 0, $fill, true, 'L', true);

			if (parent::GetY() + 20 > parent::getPageHeight() - PDF_MARGIN_BOTTOM)
				parent::AddPage();

			$height = parent::getLastH();
			$this->Ln();

			if ($table->fondo)
				$fill = !$fill;
		}
		$this->Cell(array_sum($widths), 0, '', 'T', $table->salto);

		// set document positions
		parent::SetXY(parent::GetX() + $this->separator, parent::GetY());
		if ($absolute_position)
			$this->last_width = parent::GetX();
		$y = parent::GetY();
		
		if ($y > $this->last_height)
			$this->last_height = $y;
	}

	public function Header() {
		if (isset($this->header->image))
			$this->add_image($this->header->image);

		if (isset($this->header->frame))
			$this->add_frame($this->header->frame);

		if (isset($this->background_img)) {
                        $img = $this->background_img;
			parent::Image($img->url, $img->x, $img->y, $img->w, $img->y);
		}
	}

	public function Footer() {
		if (isset($this->footer->image))
			$this->add_image($this->footer->image);

		if (isset($this->footer->frame))
			$this->add_frame($this->footer->frame);
	}

	public function set_header($header) {
		$this->header = $header;
	}

	public function set_footer($footer) {
		$this->footer = $footer;
	}

	public function set_back_img($img) {
		$this->background_img = $img;
	}
}
