<?php

require_once 'pdf.php';

class JSON2PDF {
	public $pdf = null;
	
	public function __construct($document) {
		$orientation = $this->validate_orientation($document);
		$format = $this->validate_format($document);
		$theme = $this->validate_theme($document);
		$this->pdf = new PDF($orientation, $format, $theme);

		if (isset($document->header))
			$this->set_header($document->header);

		if (isset($document->footer))
			$this->set_footer($document->footer);

		if (isset($document->fondo))
			$this->set_back_img($document->fondo);

		if (isset($document->fuente))
			$this->add_font($document->fuente);
		else {  // Esto nada mas es para cargar la fuente default
			$font = new stdClass();
			$this->add_font($font);
		}

		$this->add_pages($document->paginas);
		$this->pdf->Output();
	}

	private function validate_orientation($element) {
		if (isset($element->orientacion))
			return $element->orientacion;

		return PDF::$document_orientation;
	}

	private function validate_format($element) {
		if (isset($element->formato))
			return $element->formato;

		return PDF::$document_format;
	}

	private function validate_theme($document) {
		if (!isset($document->tema))
			return 'gray';
		
		switch ($document->tema) {
			case 'blue':
			case 'red':
			case 'green':
				return $document->tema;
		}

		return 'gray';
	}

	private function add_font($font) {
		$current_font = $this->pdf->get_current_font();

		if (!isset($font->tipo))
			$font->tipo = $current_font->tipo;
		
		if (!isset($font->estilo))
			$font->estilo = $current_font->estilo;

		if (!isset($font->tamano))
			$font->tamano = $current_font->tamano;

		if (!isset($font->color))
			$font->color = $current_font->color;

		$this->pdf->add_font($font);
	}

	private function add_pages($pages) {
		foreach ($pages as $page) {
			$orientation = $this->validate_orientation($page);
			$format = $this->validate_format($page);

			if (isset($page->fuente)) {
				$this->add_font($page->fuente);
				unset($page->fuente);
				$reestablish_font = true;
			}

			$this->pdf->add_page($orientation, $format);

			foreach ($page->elementos as $element) {
				switch ($element->tipo) {
					case 'marco':
						$this->add_frame($element);
						break;

					case 'tabla':
						$this->add_table($element);
						break;
					
					case 'imagen':
						$this->add_image($element);
						break;
				}
			}

			if (isset($reestablish_font))
				$this->pdf->reestablish_font();
		}
	}

	private function add_frame($frame) {
			if (isset($frame->fuente)) {
				$this->add_font($frame->fuente);
				unset($frame->fuente);
				$reestablish_font = true;
			}

			$frame = $this->validate_frame($frame);

			$this->pdf->add_frame($frame);

			if (isset($reestablish_font)) {
				$this->pdf->reestablish_font();
				$reestablish_font = NULL;
			}
	}

	private function validate_frame($frame) {
		if (!isset($frame->ancho))
				$frame->ancho = 0;

			if (!isset($frame->altura))
				$frame->altura = 0;

			if (!isset($frame->borde))
				$frame->borde = 0;

			if (!isset($frame->fondo))
				$frame->fondo = 1;

			if (!isset($frame->alineacion))
				$frame->alineacion = 'L';

			if (!isset($frame->texto))
				$frame->texto = "";

			if (!isset($frame->salto))
				$frame->salto = 0;

			return $frame;
	}

	private function add_image($image) {
			$image = $this->validate_image($image);

			$this->pdf->add_image($image);
	}

	private function validate_image($image) {
			if (!isset($image->ancho))
				$image->ancho = 0;

			if (!isset($image->altura))
				$image->altura = 0;

			if (!isset($image->alineacion))
				$image->alineacion = '';

			if (!isset($image->borde))
				$image->borde = '';

			return $image;
	}

	public function add_table($table) {
		if (isset($table->fuente)) {
			$this->add_font($table->fuente);
			unset($table->fuente);
			$reestablish_font = true;
		}

		if (!isset($table->ancho))
			$table->ancho = 0;

		if (!isset($table->borde))
			$table->borde = 1;

		if (!isset($table->salto))
			$table->salto = 0;

		if (!isset($table->fondo))
				$table->fondo = 1;

		$this->pdf->add_table($table);

		if (isset($reestablish_font))
			$this->pdf->reestablish_font();
	}

	public function set_header($header) {
		if (isset($header->imagen))
			$header->image = $this->validate_image($header->imagen);

		if (isset($header->marco))
			$header->frame = $this->validate_frame($header->marco);

		$this->pdf->set_header($header);
	}

	public function set_footer($footer) {
		if (isset($footer->imagen))
			$footer->image = $this->validate_image($footer->imagen);

		if (isset($footer->marco))
			$footer->frame = $this->validate_frame($footer->marco);

		if (isset($footer->tamano))
			$footer->size = $footer->tamano;
		else
			$footer->size = -20;

		$this->pdf->set_footer($footer);
	}

	public function set_back_img($img) {
                if (!isset($img->x))
                        $img->x = 0;
                if (!isset($img->y))
                        $img->y = 0;
                if (!isset($img->w))
                        $img->w = 0;
                if (!isset($img->h))
                        $img->h = 0;
		$this->pdf->set_back_img($img);
	}
}
