$answer = array(
	'error'=>array('int','ID ошибки','0'),
	'error_text'=>array('str','текст ошибки'),	
	'servers'=> array(
		'arrays',
		'Массив серверов',
		array(
			'id'=>array('int','ID версии'),
			'name'=> array('string','Название'),			
			'text'=> array('string','Описание'),
			'ip' => array('string','IP сервера'),					
			'rank' => array('int','рейтинг'),					
			'versions' => array(
				'object',
				'Массив версий от какой (объект from) и до какой (объект to)',
				array(					
					'from' => array(
						'object',
						'Версия от какой',
						array(					
							'id' => array('int','ID версии'),
							'name' => array('string','Имя версии'),															
						),
					),
					'to' => array(
						'object',
						'Версий до какой',
						array(					
							'id' => array('int','ID версии'),
							'name' => array('string','Имя версии'),		
						),
					),															
				)
			),		
		),
	),	
);

echo '<pre>' . getExampleJson($answer, 0, 6) . </pre>

/**
 * 
 * @param type $array массив описания объекта
 * @param type $iteration_num номер текущей итерации
 * @param type $iteration_cnt кол-во итераций
 * @param type $symbol символ отступа
 * @param type $symbol_cnt кол-во сиволов для отступа
 * @return string строка постоенного json который будет возвращен с символами отступов и переноса, которую можно вывести в теге <pre>
 */
function getExampleJson($array, $iteration_num = 0, $iteration_cnt = 5, $symbol = '&nbsp;', $symbol_cnt = 4)
{	
	++$iteration_num; // плюсуем номер итерации. Так проще строить необходимые отступы без лишнего повтора инкремента и лишь в конце сделать выполнить деремент
			
	if (intval($iteration_cnt) <=0) { // останавливаем итерацию и просто выводим тип				
		return '';
	}
	
	// открываем объект
	$str = "{\r\n";	
	foreach ($array as $k=>$v)
	{		
		// формируем отступ для текущей итерации 
		$indent = str_repeat($symbol, $iteration_num * $symbol_cnt);
		
		$str .= $indent;		
		if (is_array($v[2]) AND (intval($iteration_cnt) > 1)){ // если массив и не надо будет прервать итерацию, то повторяем итерацию			
			$str .= "\"{$k}\": "				
				. (($v[0]=='arrays')?"[ ":'') // если массивы, то ставим соответсвующий символ, что бы не путать разработчика
				. ((intval($iteration_cnt) > 0) ? ("\r\n" . $indent) : '') // отступ не нужен, если заканчиваем итерацию
				. getExampleAnswer($v[2], $iteration_num, $iteration_cnt - 1) . ((intval($iteration_cnt) > 0) ? $indent : '')  
				. (($v[0]=='arrays') ? ("\r\n{$indent}...\r\n{$indent}],\r\n") : ((intval($iteration_cnt) > 0) ? "\r\n" : '') ); //
				//."\r\n";						
		} else {
			$str .= "\"{$k}\": \"{$v[0]}\", \r\n"; // просто выводим тип
		}							
	}
	// финальный отступ для закрытия объекта
	$str .= str_repeat($symbol, ($iteration_num - 1) * $symbol_cnt). "}";
	
	return $str;
}
