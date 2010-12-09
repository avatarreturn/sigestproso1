--
-- Base de datos: `grupo01`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(20) NOT NULL,
  `password` varchar(10) NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish_ci,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcar la base de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `descripcion`, `fecha`) VALUES
(1, 'marsant', '3379', 'administrador', '2010-12-04'),
(2, 'pepe', '1234', 'jefeProyecto', '2010-12-04'),
(3, 'ana', '321', 'desarrollador', '2010-12-04'),
(4, 'juan', '789', 'responsablePersonal', '2010-12-04');
